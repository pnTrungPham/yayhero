
<?php

/**
 * Plugin Name:     Alan Project
 * Plugin URI:      https://wpsource.tech/
 * Description:     Starter plugin.Basic WordPress plugin development.
 * Author:          Yay Commerce
 * Author URI:      https://wpsource.tech/
 * Text Domain:     wpsource
 * Domain Path:     /languages
 * Version:         1.0
 *
 * @package wpsource
 */

if (!defined('ABSPATH')) {
    die('We\'re sorry, but you can not directly access this file.');
}

define('YAY_HERO_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('YAY_HERO_PLUGIN_URL', plugin_dir_url(__FILE__));
define('YAY_HERO_IS_DEVELOPMENT', true);

if (!wp_installing()) {

    add_action(
        'plugins_loaded',
        function () {
            include YAY_HERO_PLUGIN_PATH . 'includes/pages/wpsource-admin.php';
            include YAY_HERO_PLUGIN_PATH . 'includes/enqueue/wpsource-app.php';
            include YAY_HERO_PLUGIN_PATH . 'includes/api/wpsource-api.php';
        }
    );
}
