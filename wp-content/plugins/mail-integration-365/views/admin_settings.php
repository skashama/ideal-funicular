<?php
/**
 * Mail Integration for Office 365 - Admin Settings View
 *
 * Displays the admin settings page HTML
 *
 * @author            Edward Cross
 * @copyright         2020 Cross Connected
 * @license           GPL-2.0-or-later
 **/
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

use Classes\Mail_Integration_365;

?>
<div class="wrap">
	<div style="margin: 20px">
    <svg width="100px" height="100px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
            viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
        <g>
            <g>
                <g>
                    <path fill="#316CFF" d="M32,0c17.7,0,32,14.3,32,32S49.7,64,32,64S0,49.7,0,32S14.3,0,32,0z"/>
                </g>
            </g>
            <g>
                <g>
                    <polygon fill="#FFD41D" points="32,9 13,22 13,35 32,35 51,35 51,22 			"/>
                </g>
            </g>
            <g>
                <g>
                    <path fill="#FFFFFF" d="M45,13v30c0,0.5-0.5,1-1,1H20c-0.5,0-1-0.5-1-1V13c0-0.6,0.5-1,1-1h24C44.5,12,45,12.4,45,13z"/>
                </g>
            </g>
            <g>
                <g>
                    <path fill="#D3D5DD" d="M40.1,18c0.5,0,0.9,0.5,0.9,1s-0.4,1-0.9,1H23.9c-0.5,0-0.9-0.5-0.9-1s0.4-1,0.9-1H40.1z"/>
                </g>
            </g>
            <g>
                <g>
                    <path fill="#D3D5DD" d="M40.1,23c0.5,0,0.9,0.5,0.9,1s-0.4,1-0.9,1H23.9c-0.5,0-0.9-0.5-0.9-1s0.4-1,0.9-1H40.1z"/>
                </g>
            </g>
            <g>
                <g>
                    <polygon fill="#D1D5DB" points="32,35 13,22 13,48 51,48 51,22 			"/>
                </g>
            </g>
            <g>
                <g>
                    <path fill="#E1E5EA" d="M51,48L35.2,32.2h-6.4L13,48H51z"/>
                </g>
            </g>
        </g>
        </svg>
        <h2 style="display: inline-block; position: absolute; top: 50px; margin-left: 20px"><?php esc_html_e(get_admin_page_title(), Mail_Integration_365\Core::$text_domain); ?></h2>
    </div>
	<?php
        // Display settings errors on first load without form submission
        settings_errors(Classes\Mail_Integration_365\Admin::$settings_page_slug, false, false);
        
        // Check if page is loaded over SSL
        global $mail_integration_365_ssl_check;
        if ($mail_integration_365_ssl_check) {
            ?>
        <h2>Donations</h2>
		<h3><?php _e("If you find this plugin useful and wish to aid it's development, any donations would be greatly received."); ?></h3>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			<input type="hidden" name="cmd" value="_s-xclick" />
			<input type="hidden" name="hosted_button_id" value="FKKRQ4K23RQYJ" />
			<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="<?php _e('PayPal - The safer, easier way to pay online!', Mail_Integration_365\Core::$text_domain); ?>" alt="<?php _e('Donate with PayPal button', Mail_Integration_365\Core::$text_domain); ?>" />
			<img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1" />
		</form>
		<h4><?php _e('To connect to your Office 365/personal Outlook account, you need to follow the steps in the following guide to get the three required credentials requested below: ', Mail_Integration_365\Core::$text_domain); ?><a href="https://crossconnected.co.uk/mail-integration-365-wordpress-plugin">https://crossconnected.co.uk/mail-integration-365-wordpress-plugin</a></h4>
		<form method="post" action="options.php">		
			<?php
            foreach (Mail_Integration_365\Admin::$settings as $key1 => $value1) {
                settings_fields(Mail_Integration_365\Admin::$settings_page_slug . '_' . $key1);
                do_settings_sections(Mail_Integration_365\Admin::$settings_page_slug . '_' . $key1);
                
                // Check if client id, client secret and tenant ID are set, displaying either a message to request these are set, or button with the authorisation url hyperlink
                if ($key1 == "oauth_settings") {
                    if (get_transient(get_current_user_id() . 'mail-integration-365-oauth2-auth-url')) {
                        printf('<table class="form-table" role="presentation"><tbody><tr><th scope="row"><label for="mail_integration_365_plugin_ops_authorisation_field">Authorisation</label></th><td><a href="%1$s" class="button button-secondary">Authorise plugin to integrate with Office 365</a></td></tr></tbody></table>', get_transient(get_current_user_id() . 'mail-integration-365-oauth2-auth-url'));
                    } else {
                        echo '<table class="form-table" role="presentation"><tbody><tr><th scope="row"><label for="mail_integration_365_plugin_ops_authorisation_field">Authorisation</label></th><td><p class="notice notice-warning" style="width: 300px">You need to save settings with a valid Tenant ID, Client ID and Client Secret before you can proceed.</p></td></tr></tbody></table>';
                    }
                }
            }

            submit_button(); ?>
		</form>
		<h2>Donations</h2>
		<h3><?php _e("If you find this plugin useful and wish to aid it's development, any donations would be greatly received."); ?></h3>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			<input type="hidden" name="cmd" value="_s-xclick" />
			<input type="hidden" name="hosted_button_id" value="FKKRQ4K23RQYJ" />
			<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="<?php _e('PayPal - The safer, easier way to pay online!', Mail_Integration_365\Core::$text_domain); ?>" alt="<?php _e('Donate with PayPal button', Mail_Integration_365\Core::$text_domain); ?>" />
			<img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1" />
		</form>
	<?php
        }
    ?>
</div>
