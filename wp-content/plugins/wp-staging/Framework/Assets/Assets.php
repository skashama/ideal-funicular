<?php

namespace WPStaging\Framework\Assets;

use WPStaging\Backend\Modules\Jobs\Scan;
use WPStaging\Core\DTO\Settings;
use WPStaging\Core\WPStaging;
use WPStaging\Framework\Security\AccessToken;
use WPStaging\Framework\Security\Nonce;

class Assets
{
    private $accessToken;

    private $settings;

    public function __construct(AccessToken $accessToken, Settings $settings)
    {
        $this->accessToken = $accessToken;
        $this->settings    = $settings;
    }

    /**
     * Prepand the URL to the assets to the given file
     *
     * @param string $assetsFile optional
     * @return string
     */
    public function getAssetsUrl($assetsFile = '')
    {
        return WPSTG_PLUGIN_URL . "assets/$assetsFile";
    }

    /**
     * Get the version the given file. Use for caching
     *
     * @param string $assetsFile
     * @param string $assetsVersion, use WPStaging::getVersion() instead if not given
     * @return string
     */
    public function getAssetsUrlWithVersion($assetsFile, $assetsVersion = '')
    {
        $url = $this->getAssetsUrl($assetsFile);
        $ver = $this->getAssetsVersion($assetsFile, $assetsVersion);
        return $url . '?v=' . $ver;
    }

    /**
     * Prepand the Path to the assets to the given file
     *
     * @param string $assetsFile optional
     * @return string
     */
    public function getAssetsPath($assetsFile = '')
    {
        return WPSTG_PLUGIN_DIR . "assets/$assetsFile";
    }

    /**
     * Get the version the given file. Use for caching
     *
     * @param string $assetsFile
     * @param string $assetsVersion Optional, use WPStaging::getVersion() instead if not given
     * @return string
     */
    public function getAssetsVersion($assetsFile, $assetsVersion = '')
    {
        $filemtime = @filemtime($this->getAssetsPath($assetsFile));

        if ($filemtime !== false) {
            return $filemtime;
        } else {
            return $assetsVersion !== '' ? $assetsVersion : WPStaging::getVersion();
        }
    }

    /**
     * @action admin_enqueue_scripts 100 1
     * @action wp_enqueue_scripts 100 1
     */
    public function enqueueElements($hook)
    {
        // Load this css file on frontend and backend on all pages if current site is a staging site
        if (wpstg_is_stagingsite()) {
            $asset = 'css/src/frontend/wpstg-admin-bar.css';
            wp_enqueue_style(
                "wpstg-admin-bar",
                $this->getAssetsUrl($asset),
                [],
                $this->getAssetsVersion($asset)
            );
        }

        // Load js file on page plugins.php in free version only
        if (!defined('WPSTGPRO_VERSION') && $this->isPluginsPage()) {
            $asset = 'js/dist/wpstg-admin-plugins.js';
            wp_enqueue_script(
                "wpstg-admin-script",
                $this->getAssetsUrl($asset),
                ["jquery"],
                $this->getAssetsVersion($asset),
                false
            );

            $asset = 'css/src/wpstg-admin-feedback.css';
            wp_enqueue_style(
                "wpstg-admin-feedback",
                $this->getAssetsUrl($asset),
                [],
                $this->getAssetsVersion($asset)
            );
        }

        if ($this->isDisabledAssets($hook)) {
            return;
        }

        // Load admin js files
        $asset = 'js/dist/wpstg-admin.js';
        wp_enqueue_script(
            "wpstg-admin-script",
            $this->getAssetsUrl($asset),
            ["jquery"],
            $this->getAssetsVersion($asset),
            false
        );

        // Load admin js files
        $asset = 'js/dist/wpstg-legacy-database.js';
        wp_enqueue_script(
            "wpstg-legacy-database",
            $this->getAssetsUrl($asset),
            ["wpstg-admin-script"],
            $this->getAssetsVersion($asset),
            false
        );
        // Sweet Alert
        $asset = 'js/vendor/sweetalert2.all.min.js';
        wp_enqueue_script(
            'wpstg-admin-sweetalerts',
            $this->getAssetsUrl($asset),
            [],
            $this->getAssetsVersion($asset),
            true
        );

        $asset = 'css/vendor/sweetalert2.min.css';
        wp_enqueue_style(
            'wpstg-admin-sweetalerts',
            $this->getAssetsUrl($asset),
            [],
            $this->getAssetsVersion($asset)
        );

        // Notyf Toast Notification
        $asset = 'js/vendor/notyf.min.js';
        wp_enqueue_script(
            'wpstg-admin-notyf',
            $this->getAssetsUrl($asset),
            [],
            $this->getAssetsVersion($asset),
            true
        );

        $asset = 'css/vendor/notyf.min.css';
        wp_enqueue_style(
            'wpstg-admin-notyf',
            $this->getAssetsUrl($asset),
            [],
            $this->getAssetsVersion($asset)
        );

        // Load admin js pro files
        if (defined('WPSTGPRO_VERSION')) {
            $asset = 'js/dist/pro/wpstg-admin-pro.js';
            wp_enqueue_script(
                "wpstg-admin-pro-script",
                $this->getAssetsUrl($asset),
                ["jquery"],
                $this->getAssetsVersion($asset),
                false
            );
        }

        // Load admin css files
        $asset = 'css/src/wpstg-admin.css';
        wp_enqueue_style(
            "wpstg-admin",
            $this->getAssetsUrl($asset),
            [],
            $this->getAssetsVersion($asset)
        );

        // Add ability to import/export modules to wpstg-admin.js and wpstg-admin-pro.js
        add_filter('script_loader_tag', [$this, 'makeScriptsES6'], 10, 3);

        wp_localize_script("wpstg-admin-script", "wpstg", [
            "delayReq"               => $this->getDelay(),
            "settings"               => (object)[
                "directorySeparator"  => Scan::DIRECTORIES_SEPARATOR,
            ],
            "tblprefix"              => WPStaging::getTablePrefix(),
            "isMultisite"            => is_multisite(),
            AccessToken::REQUEST_KEY => (string)$this->accessToken->getToken() ?: (string)$this->accessToken->generateNewToken(),
            'nonce'                  => wp_create_nonce(Nonce::WPSTG_NONCE),
            'ajaxUrl'                => admin_url('admin-ajax.php'),
            // TODO: handle i18n translations through Class/Service Provider?
            'i18n'                   => [
                'dbConnectionSuccess' => esc_html__('Database Connection - Success', 'wp-staging'),
                'dbConnectionFailed'  => esc_html__('Database Connection - Failed', 'wp-staging'),
                'somethingWentWrong'  => esc_html__('Something went wrong.', 'wp-staging'),
                'noImportFileFound'  => esc_html__('No import file found.', 'wp-staging'),
                'selectFileToImport' => esc_html__('Select file to import.', 'wp-staging'),
            ],
        ]);
    }

    /**
     * Load css and js files only on wp staging admin pages
     *
     * @param $page string slug of the current page
     *
     * @return bool
     */
    private function isDisabledAssets($page)
    {
        if (defined('WPSTGPRO_VERSION')) {
            $availablePages = [
                "toplevel_page_wpstg_clone",
                "wp-staging-pro_page_wpstg-settings",
                "wp-staging-pro_page_wpstg-tools",
                "wp-staging-pro_page_wpstg-license",
            ];
        } else {
            $availablePages = [
                "toplevel_page_wpstg_clone",
                "wp-staging_page_wpstg-settings",
                "wp-staging_page_wpstg-tools",
                "wp-staging_page_wpstg-welcome",
            ];
        }

        return !in_array($page, $availablePages) || !is_admin();
    }

    /**
     * Check if current page is plugins.php
     * @global array $pagenow
     * @return bool
     */
    private function isPluginsPage()
    {
        global $pagenow;

        return ($pagenow === 'plugins.php');
    }


    /**
     * Remove heartbeat api and user login check
     *
     * @action admin_enqueue_scripts 100 1
     *
     * @param bool $hook
     */
    public function removeWPCoreJs($hook)
    {
        if ($this->isDisabledAssets($hook)) {
            return;
        }

        // Disable user login status check
        // Todo: Can we remove this now that we have AccessToken?
        remove_action('admin_enqueue_scripts', 'wp_auth_check_load');

        // Disable heartbeat check for cloning and pushing
        wp_deregister_script('heartbeat');
    }

    /**
     * @return array|mixed|object
     */
    public function getDelay()
    {
        switch ($this->settings->getDelayRequests()) {
            case "0":
                $delay = 0;
                break;

            case "1":
                $delay = 1000;
                break;

            case "2":
                $delay = 2000;
                break;

            case "3":
                $delay = 3000;
                break;

            case "4":
                $delay = 4000;
                break;

            default:
                $delay = 0;
        }

        return $delay;
    }

    public function makeScriptsES6($tag, $handle, $source)
    {
        if ($handle === 'wpstg-admin-pro-script' || $handle === 'wpstg-admin-script') {
            $tag = '<script src="' . $source . '" type="module"></script>';
        }

        return $tag;
    }
}
