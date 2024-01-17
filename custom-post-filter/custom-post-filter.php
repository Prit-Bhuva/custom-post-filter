<?php

/**
 * Plugin Name:       Custom Post Filter change
 * Description:       A plugin to add post filtering functionality. Use shortcode <strong>[post_filter]</strong> to display post filter and <strong>[related_insights]</strong> to display related post.
 * Version:           1.0.0
 * Author:            Prit bhuva
 * Text Domain:       CPF
 */

defined('ABSPATH') || die("Invalid Request");

if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.12');
}


/**
 * ============================
 * define plugin path/url/file
 * ============================
 */
define('PLUGIN_PATH', plugin_dir_path(__FILE__));
define('PLUGIN_URL', plugin_dir_url(__FILE__));
define('PLUGIN_FILE', __FILE__);

/**
 * =============
 * Include Path
 * =============
 */
include PLUGIN_PATH . 'view/class-custom-post-filter.php';
include PLUGIN_PATH . 'view/custom-post-filter-activation.php';
include PLUGIN_PATH . 'view/shortcode-custom-post-filter.php';
include PLUGIN_PATH . 'view/shortcode-related-insights.php';
include PLUGIN_PATH . 'view/ajax-post-filter.php';

/**
 * ================
 * Enqueue scripts
 * ================
 */
if (!class_exists('post_filter_scripts')) :

    class PostFilter
    {

        public function __construct()
        {
            // Add a script to the list of enqueued scripts to be loaded in the footer.
            add_action('wp_enqueue_scripts', array(__CLASS__, 'add_enqueue_scripts'));

            // Hook into admin menu creation process
            add_action('admin_enqueue_scripts',  array(__CLASS__, 'enqueue_admin_styles'));

            // Hook into admin menu creation process
            add_action('admin_menu', array('CustomPostFilterActivation', 'createMenu'));

            // Hook into activation process
            register_activation_hook(__FILE__, array(__CLASS__, 'activate'));
        }

        /**
         * Activate the function.
         *
         * @return void
         */
        public static function activate()
        {
            CustomPostFilterActivation::activate();
        }

        /**
         * Adds a script to the list of enqueued scripts to be loaded in the footer.
         */
        public static function add_enqueue_scripts()
        {
            wp_enqueue_style('custom-post-filter-css', PLUGIN_URL . 'assets/css/filter.css', array(), _S_VERSION, 'all');
            wp_enqueue_script('custom-post-filter', PLUGIN_URL . 'assets/js/script.js', array('jquery'), _S_VERSION, true);

            // Localize the script with pluginUrl
            wp_localize_script('localize-script-handle', 'pluginUrl', array('url' => plugins_url()));
        }

        /**
         * Enqueue the admin styles.
         *
         * @return void
         */
        public static function enqueue_admin_styles()
        {
            wp_enqueue_style('custom-admin-styles', PLUGIN_URL . 'assets/css/options-page.css', array(), _S_VERSION, 'all');
            wp_enqueue_style('chosen-css', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css');

            wp_enqueue_script('chosen-js', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js', ['jquery'], '1.8.7', true);
            wp_enqueue_script('custom-admin-js', PLUGIN_URL . 'assets/js/options-page.js', ['jquery'], _S_VERSION, true);
        }
    }
    new PostFilter;
endif;
