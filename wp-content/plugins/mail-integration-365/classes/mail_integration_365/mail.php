<?php
/**
 * Mail Integration for Office 365 - Mail Class
 *
 * Captures overridden wp_mail() events, instigating a Microsoft
 * Graph API request using OAuth2 authentication rather than
 * the SMTP protocol
 *
 * @author            Edward Cross
 * @copyright         2020 Cross Connected
 * @license           GPL-2.0-or-later
 **/
namespace Classes\Mail_Integration_365;

use TheNetworg\OAuth2\Client\Provider\Azure;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

if (!class_exists("Classes\Mail_Integration_365\Mail")) {
    class Mail
    {
        public $options;

        /**
         * Construct class object
         */
        public function __construct()
        {
            // wp_mail() filter hook to forward arguments to custom send() function
            add_filter("wp_mail", array($this, "send"));
            
            // Get main plugin options
            $this->options = get_option(Admin::$options_name);            
        }
      
        /**
         * Custom send() function using captured wp_mail() event arguments
         * to send an email via the Microsoft Graph API using OAuth2 credentials
         *
         * @param   array   $args   An array containing the captured wp_mail() arguments
         */
        public function send($args)
        {
            try {
                // Set up the OAuth2 provider using the Azure OAuth2 PHP Library
                $provider = new Azure([
                    "clientId" => $this->options[Admin::$options_name . "_client_id_field"],
                    "clientSecret" => $this->options[Admin::$options_name . "_client_secret_field"],
                    "redirectUri" => $this->options[Admin::$options_name . "_redirect_uri_field"],
                    "tenant" => $this->options[Admin::$options_name . "_tenant_id_field"]
                ]);

                $access_token = get_option(Admin::$options_name . "_access_token");
                
                $from = $this->options[Admin::$options_name . "_send_as_email_field"];

                // Loop through email headers to check content type
                $headers = array();
                if (isset($args['headers'])) {
                    if (is_array($args['headers'])) {
                        $headers = $args['headers'];
                    } else {
                        $headers = explode("\n", str_replace("\r\n", "\n", $args['headers']));
                    }
                }
                
                // Process email headers
                foreach ($headers as $header) {
                    if (strpos($header, ':') === false) {
                        continue;
                    }

                    list($name, $content) = explode(':', trim($header), 2);

                    $name    = trim($name);
                    $content = trim($content);
             
                    if ('content-type' === strtolower($name)) {
                        if (strpos($content, ';') !== false) {
                            list($type, $charset) = explode(';', $content);
                            $content_type = trim($type);
                        } else {
                            $content_type = trim($content);
                        }
                        break;
                    } elseif('reply-to' === strtolower($name)) {
                        $from = $content;
                    }
                }

                // Set content type to allowed types for Microsoft Graph SendMail
                if (!isset($content_type)) {
                    $graph_content_type = "Text";
                } elseif ($content_type == "text/plain") {
                    $graph_content_type = "Text";
                } elseif ($content_type == "text/html") {
                    $graph_content_type = "HTML";
                } else {
                    $graph_content_type = "Text";
                }

                // Create the email body object that can be serialised as JSON
                $body = array(
                    "message" => array(
                        "subject" => $args["subject"],
                        "body" => array(
                            "contentType" => $graph_content_type,
                            "content" => $args["message"],
                        ),
                        "toRecipients" => array(),
                    ),
                    "saveToSentItems" => "true", // Set to store emails in saved items by default
                );
                
                // Parse to address/es
                if (!is_array($args["to"]) && empty(explode(",", $args["to"]))) {
                    array_push($body["message"]["toRecipients"], array("emailAddress" => array("address" => $args["to"])));
                } else {
                    if (!is_array($args["to"])) {
                        $args["to"] = explode(",", $args["to"]);
                    }
                    
                    foreach ($args["to"] as $email) {
                        array_push($body["message"]["toRecipients"], array("emailAddress" => array("address" => $email)));
                    }
                }
                
                // Send mail from a specified account
                if (isset($this->options[Admin::$options_name . "_enable_send_as_field"]) && $this->options[Admin::$options_name . "_enable_send_as_field"] === 'on' && isset($this->options[Admin::$options_name . "_send_as_email_field"])) {
                    $body["message"]["from"] = array(
                        "emailAddress" => array(
                            "address" => $from
                        )
                    );
                }
                
                // Set Azure endpoint version
                $provider->defaultEndPointVersion = Azure::ENDPOINT_VERSION_2_0;
                
                // Get the base Microsoft Graph URI
                $base_graph_uri = $provider->getRootMicrosoftGraphUri(null);
 
                // Check if access token has expired and update plugin options with new access token.
                // The post() function used to instigate the API request below, does also check this by
                // default. However, it does not return the new access token to save.
                if ($access_token->hasExpired()) {
                    // Request a new access token using the refresh token embedded in $access_token
                    $access_token = $provider->getAccessToken("refresh_token", [
                        "refresh_token" => $access_token->getRefreshToken()
                    ]);

                    // Update the current saved access token with the new one
                    update_option(Admin::$options_name . "_access_token", $access_token);
                }
                
                // Handle email attachments
                if (!$args["attachments"] || $args["attachments"] == "") {
                    // Send the API request via the Azure OAuth2 PHP library"s post() function
                    $provider->post($base_graph_uri . "/v1.0/me/sendMail", $body, $access_token);
                } else {
                    $total_size = 0;
                    $body["message"]["attachments"] = array();
                    
                    // Check if total attachments are over 3MB in size
                    if (is_array($args["attachments"])) {
                        foreach ($args["attachments"] as $key => $file) {
                            $handle = fopen($file, 'r');
                            $file_size = fileSize($file);
                            $total_size += $file_size;
                            $attachment = array(
                                '@odata.type' => '#microsoft.graph.fileAttachment',
                                'name' => basename($file),
                                'contentType' => mime_content_type($file),
                                'contentBytes' => base64_encode(fread($handle, $file_size)),
                            );
                            array_push($body["message"]["attachments"], $attachment);
                        }
                    } else {
                        $handle = fopen($file, 'r');
                        $file_size = fileSize($args["attachments"]);
                        $total_size += $file_size;
                        $attachment = array(
                            '@odata.type' => '#microsoft.graph.fileAttachment',
                            'name' => basename($file),
                            'contentType' => mime_content_type($file),
                            'contentBytes' => base64_encode(fread($handle, $file_size)),
                        );
                        array_push($body["message"]["attachments"], $attachment);
                    }

                    if ($total_size > 3145728) {
                        // Set message to null to stop wp_mail returning true
                        $args["to"] = "";
						
                        throw new IdentityProviderException('Attachments were too large to email via Mail Integration 365');
                    } else {
                        // Send the API request via the Azure OAuth2 PHP library"s post() function
                        $provider->post($base_graph_uri . "/v1.0/me/sendMail", $body, $access_token);
                    }
                }
            } catch (IdentityProviderException $e) {
                echo $e->getMessage();
                
				return $args;
            } finally {
                return $args;
            }
        }
    }
}
