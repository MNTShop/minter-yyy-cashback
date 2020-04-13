<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://mntshop.ru
 * @since             1.0.0
 * @package           Minter_Yyy_Cashback
 *
 * @wordpress-plugin
 * Plugin Name:       minter-yyy-cashback
 * Plugin URI:        https://mntshop.ru
 * Description:       Plugin that give you power of rewards your client! example for registration. Use FunFasy.dev to send minter transaction and YYY.cash to generate containers with money.
 * Version:           1.0.0
 * Author:            Geman Vereschak
 * Author URI:        https://mntshop.ru
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       minter-yyy-cashback
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
require __DIR__ . '/vendor/autoload.php';

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MINTER_YYY_CASHBACK_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-minter-yyy-cashback-activator.php
 */
function activate_minter_yyy_cashback() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-minter-yyy-cashback-activator.php';
	Minter_Yyy_Cashback_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-minter-yyy-cashback-deactivator.php
 */
function deactivate_minter_yyy_cashback() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-minter-yyy-cashback-deactivator.php';
	Minter_Yyy_Cashback_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_minter_yyy_cashback' );
register_deactivation_hook( __FILE__, 'deactivate_minter_yyy_cashback' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-minter-yyy-cashback.php';
/**
 * The helpers.
 */
require plugin_dir_path( __FILE__ ) . 'includes/YYY_push.php';
require plugin_dir_path( __FILE__ ) . 'includes/FunFasy_helper.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_minter_yyy_cashback() {

	$plugin = new Minter_Yyy_Cashback();
	$plugin->run();

}
run_minter_yyy_cashback();
