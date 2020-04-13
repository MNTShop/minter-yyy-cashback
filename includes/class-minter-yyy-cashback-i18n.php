<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://mntshop.ru
 * @since      1.0.0
 *
 * @package    Minter_Yyy_Cashback
 * @subpackage Minter_Yyy_Cashback/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Minter_Yyy_Cashback
 * @subpackage Minter_Yyy_Cashback/includes
 * @author     Geman Vereschak <general@mntshop.ru>
 */
class Minter_Yyy_Cashback_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'minter-yyy-cashback',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
