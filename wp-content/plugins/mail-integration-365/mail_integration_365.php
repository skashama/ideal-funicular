<?php
/**
 * Mail Integration for Office 365
 *
 * @author            Edward Cross
 * @copyright         2020 Cross Connected
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Mail Integration for Office 365/Outlook
 * Description:       Plugin for sending mail via Office 365/Outlook using OAuth2 and Microsoft's Graph API rather than SMTP.
 * Version:           1.5.0
 * Requires PHP:      7.1.1
 * Author:            Edward Cross
 * Author URI:        https://crossconnected.co.uk
 * Text Domain:       mail-integration-365
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// AutoLoad Azure OAuth2 PHP Library
include_once(dirname(__FILE__) . "/libs/vendor/autoload.php");

// Autoload plugin classes
spl_autoload_register("mail_integration_365_autoloader");

/**
 * The autoloader function to load all the plugin"s classes
 *
 * @param   string      $class_name     The name of the class currently being loaded
 */
function mail_integration_365_autoloader($class_name)
{
    if (false !== strpos($class_name, "Mail_Integration_365")) {
        $file = strtolower(str_replace("\\", DIRECTORY_SEPARATOR, $class_name));
        require_once $file . ".php";
    }
}

// Instantiate the Core class containing core plugin methods and functionality
new Classes\Mail_Integration_365\Core(__FILE__, plugin_dir_path(__FILE__));

// Override pluggable wp_mail() function
if (!function_exists("wp_mail")) {
    /**
     * Override wp_mail() function to capture wp_mail events and avoid triggering of phpmailer
     *
     * @param   string          $to             The email address the email is to be sent to
     * @param   string          $subject        The email subject
     * @param   string          $message        The main content of the email
     * @param   string/array    $headers        The email headers
     * @param   array           $attachments    The email file attachments
     * @return  bool            $bool           Whether the email contents were sent successfully.
     */
    function wp_mail($to, $subject, $message, $headers = "", $attachments = array())
    {
        // This filter is used to catch wp_mail arguments
        $args = apply_filters("wp_mail", compact("to", "subject", "message", "headers", "attachments"));
        
        // Check for mail errors
        if($args["to"] == "") {
            return false;
        } else {
            return true;
        }
    }
}
