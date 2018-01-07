<?php
/**
 * @since      1.0
 * @access     public
 * @author  Maksym Prihodko
 * @package wp-code-deploy
 * @subpackage wp-code-deploy-classes
 */

class WPCD_Admin extends WPCD
{

    /**
     * Register Activation Hooks
     *
     * @since  1.0
     * @access public
     * @return void
     */

    public function __construct()
    {
        add_action('admin_menu', array($this, 'register_admin_menu'));
    }


    /**
     * Register Admin Pages
     *
     * @since  1.0
     * @access public
     * @return void
     */

    public function register_admin_menu()
    {
        add_menu_page(
            'WP Code Deploy',
            'WP Code Deploy',
            'manage_options',
            'wp-code-deploy',
            array($this, 'wp_code_deploy_callback'),
            'dashicons-cloud',
            6
        );
        $deployPrefix = add_submenu_page(
            'wp-code-deploy',
            'Deploy',
            'Deploy',
            'manage_options',
            'wp-code-deploy',
            array($this, 'wp_code_deploy_callback')
        );
        $settingsPrefix = add_submenu_page(
            'wp-code-deploy',
            'Settings',
            'Settings',
            'manage_options',
            'wp-code-deploy-settings',
            array($this, 'wp_code_deploy_settings_callback')
        );
        $logsPrefix = add_submenu_page(
            'wp-code-deploy',
            'Logs',
            'Logs',
            'manage_options',
            'wp-code-deploy-logs',
            array($this, 'wp_code_deploy_logs_callback')
        );

        add_action('admin_print_scripts-' . $deployPrefix, array($this, "wp_code_deploy_scripts"));
        add_action('admin_print_scripts-' . $settingsPrefix, array($this, "wp_code_deploy_settings_scripts"));
        add_action('admin_print_scripts-' . $logsPrefix, array($this, "wp_code_deploy_logs_scripts"));

    }


    /**
     * Deploy Page Scripts
     *
     * @since  1.0
     * @access public
     * @return void
     */

    public function wp_code_deploy_scripts()
    {

    }


    /**
     * Settings Page Scripts
     *
     * @since  1.0
     * @access public
     * @return void
     */

    public function wp_code_deploy_settings_scripts()
    {
        wp_register_script("wpcd-settings-js", WPCD_PLUGIN_URI . "assets" . DIRECTORY_SEPARATOR . "js" . DIRECTORY_SEPARATOR . "settings.js", array("jquery"), WPCD_VERSION, true);
        wp_enqueue_script('wpcd-settings-js');

    }


    /**
     * Logs Page Scripts
     *
     * @since  1.0
     * @access public
     * @return void
     */

    public function wp_code_deploy_logs_scripts()
    {
        wp_register_script("wpcd-log-js", WPCD_PLUGIN_URI . "assets" . DIRECTORY_SEPARATOR . "js" . DIRECTORY_SEPARATOR . "log.js", array("jquery"), WPCD_VERSION, true);
        wp_enqueue_script('wpcd-log-js');
    }


    /**
     * Render Deploy Page
     *
     * @since  1.0
     * @access public
     * @return void
     */

    public function wp_code_deploy_callback()
    {
        WPCD::load_view('deploy');
    }


    /**
     * Render Settings Page
     *
     * @since  1.0
     * @access public
     * @return void
     */

    public function wp_code_deploy_settings_callback()
    {
        $data['private'] = ((file_exists(WPCD_PLUGIN_KEYS_DIR . "id_rsa")) ? file_get_contents(WPCD_PLUGIN_KEYS_DIR . "id_rsa") : '');
        $data['public'] = ((file_exists(WPCD_PLUGIN_KEYS_DIR . "id_rsa.pub")) ? file_get_contents(WPCD_PLUGIN_KEYS_DIR . "id_rsa.pub") : '');
        WPCD::load_view('settings', $data);
    }


    /**
     * Render Logs Page
     *
     * @since  1.0
     * @access public
     * @return void
     */

    public function wp_code_deploy_logs_callback()
    {
        $data["logFiles"] = WPCD_Logs::getLogsList("Y-m");
        WPCD::load_view('logs', $data);
    }

    /**
     * Run Admin Class
     *
     * @since  1.0
     * @access public
     * @return void
     */
    public static function run()
    {
        if (is_admin()) {
            return new WPCD_Admin;
        }
    }

}