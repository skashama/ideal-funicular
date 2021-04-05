<?php
/**
 * Mail Integration for Office 365 - Core Class
 *
 * Handles activation and deactivation hooks as well as other core methods and functionality
 *
 * @author            Edward Cross
 * @copyright         2020 Cross Connected
 * @license           GPL-2.0-or-later
 **/
namespace Classes\Mail_Integration_365;

if (!class_exists("Classes\Mail_Integration_365\Core")) {
    class Core
    {
        // Declare public static properties
        public static $root_file_path;
        public static $root_plugin_path;
        public static $text_domain = 'mail-integration-365';

        /**
         * Construct class object
         *
         *  @param   string      $root_file_path     The plugins root file path
         *  @param   string      $root_plugin_path   The plugins root path
         */
        public function __construct($root_file_path = false, $root_plugin_path = false)
        {
            self::$root_file_path = $root_file_path;
            self::$root_plugin_path = $root_plugin_path;
            
            // Register activation and deactivation hooks
            register_activation_hook(self::$root_file_path, array($this, "activate"));
            register_deactivation_hook(self::$root_file_path, array($this, "deactivate"));
            
            // Instantiate other default required classes upon Core class instantiation
            new Admin();
            new Mail();
        }

        /**
         * Run on plugin activation event
         */
        public function activate()
        {
            // Add settings option
            add_option(Admin::$options_name, array());
            add_option(Admin::$options_name . "_access_token", false);            
        }

        /**
         * Run on plugin deactivation event
         */
        public function deactivate()
        {
            $options = get_option(Admin::$options_name);
            
            // Delete plugin settings/options on deactivation if this is set to true
            if ($options[Admin::$options_name . '_keep_oauth_credentials_field'] != "on") {
                delete_option(Admin::$options_name);
                delete_option(Admin::$options_name . "_access_token");
            }
        }
    }
}
