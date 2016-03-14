<?php
/**
 * Plugin Name: WDS Shortcodes
 * Plugin URI:  http://webdevstudios.com
 * Description: Base plugin/classes/functionality for creating shortcodes.
 * Version:     0.1.0
 * Author:      WebDevStudios
 * Author URI:  http://webdevstudios.com
 * Donate link: http://webdevstudios.com
 * License:     GPLv2
 * Text Domain: wds-shortcodes
 * Domain Path: /languages
 */

/**
 * Copyright (c) 2015 WebDevStudios (email : contact@webdevstudios.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Built using generator-plugin-wp
 */

// include composer autoloader (make sure you run `composer install`!)
require_once trailingslashit( dirname( __FILE__ ) ) . 'vendor/autoload.php';

/**
 * Main initiation class
 *
 * @since  0.1.0
 * @var  string $version  Plugin version
 * @var  string $basename Plugin basename
 * @var  string $url      Plugin URL
 * @var  string $path     Plugin Path
 */
class WDS_Shortcodes_Base {

	/**
	 * Current version
	 *
	 * @var  string
	 * @since  0.1.0
	 */
	const VERSION = '0.1.0';

	/**
	 * URL of plugin directory
	 *
	 * @var string
	 * @since  0.1.0
	 */
	protected $url = '';

	/**
	 * Path of plugin directory
	 *
	 * @var string
	 * @since  0.1.0
	 */
	protected $path = '';

	/**
	 * Plugin basename
	 *
	 * @var string
	 * @since  0.1.0
	 */
	protected $basename = '';

	/**
	 * Singleton instance of plugin
	 *
	 * @var WDS_Shortcodes_Base
	 * @since  0.1.0
	 */
	protected static $single_instance = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since  0.1.0
	 * @return WDS_Shortcodes_Base A single instance of this class.
	 */
	public static function get_instance() {
		if ( null === self::$single_instance ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;
	}

	/**
	 * Sets up our plugin
	 *
	 * @since  0.1.0
	 */
	protected function __construct() {
		$this->basename = plugin_basename( __FILE__ );
		$this->url      = plugin_dir_url( __FILE__ );
		$this->path     = plugin_dir_path( __FILE__ );

		if ( ! defined( 'WDS_SHORTCODES_LOADED' ) ) {
			define( 'WDS_SHORTCODES_LOADED', true );
		}
	}

	/**
	 * Add hooks and filters
	 *
	 * @since 0.1.0
	 * @return null
	 */
	public function hooks() {
		add_action( 'init', array( $this, 'init' ) );

		if ( ! defined( 'CMB2_Loaded' ) ) {
			add_action( 'tgmpa_register', array( $this, 'register_required_plugin' ) );
		}

		do_action( 'wds-shortcodes-loaded', $this );
	}

	/**
	 * Requires CMB2 to be installed
	 */
	public function register_required_plugin() {

		$plugins = array(
			array(
				'name'     => 'CMB2',
				'slug'     => 'cmb2',
				'required' => true,
			),
		);

		$config = array(
			'domain'       => 'wds-shortcodes',
			'default_path' => '',
			'parent_slug'  => 'plugins.php',
			'capability'   => 'install_plugins',
			'menu'         => 'install-required-plugins',
			'has_notices'  => true,
			'is_automatic' => true,
			'message'      => '',
			'strings'      => array(
				'page_title'                      => __( 'Install Required Plugins', 'wds-shortcodes' ),
				'menu_title'                      => __( 'Install Plugins', 'wds-shortcodes' ),
				'installing'                      => __( 'Installing Plugin: %s', 'wds-shortcodes' ),
				// %1$s = plugin name
				'oops'                            => __( 'Something went wrong with the plugin API.', 'wds-shortcodes' ),
				'notice_can_install_required'     => _n_noop( 'The "WDS Shortcodes" plugin requires the following plugin: %1$s.', 'This plugin requires the following plugins: %1$s.' ),
				// %1$s = plugin name(s)
				'notice_can_install_recommended'  => _n_noop( 'This plugin recommends the following plugin: %1$s.', 'This plugin recommends the following plugins: %1$s.' ),
				// %1$s = plugin name(s)
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ),
				// %1$s = plugin name(s)
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ),
				// %1$s = plugin name(s)
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ),
				// %1$s = plugin name(s)
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ),
				// %1$s = plugin name(s)
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this plugin: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this plugin: %1$s.' ),
				// %1$s = plugin name(s)
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ),
				// %1$s = plugin name(s)
				'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
				'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
				'return'                          => __( 'Return to Required Plugins Installer', 'wds-shortcodes' ),
				'plugin_activated'                => __( 'Plugin activated successfully.', 'wds-shortcodes' ),
				'complete'                        => __( 'All plugins installed and activated successfully. %s', 'wds-shortcodes' ),
				// %1$s = dashboard link
			),
		);

		tgmpa( $plugins, $config );
	}

	/**
	 * Init hooks
	 *
	 * @since  0.1.0
	 * @return null
	 */
	public function init() {
		load_plugin_textdomain( 'wds-shortcodes', false, dirname( $this->basename ) . '/languages/' );
	}

	/**
	 * Magic getter for our object.
	 *
	 * @since  0.1.0
	 * @param string $field
	 * @throws Exception Throws an exception if the field is invalid.
	 * @return mixed
	 */
	public function __get( $field ) {
		switch ( $field ) {
			case 'version':
				return self::VERSION;
			case 'basename':
			case 'url':
			case 'path':
				return $this->$field;
			default:
				throw new Exception( 'Invalid '. __CLASS__ .' property: ' . $field );
		}
	}
}

/**
 * Grab the WDS_Shortcodes_Base object and return it.
 * Wrapper for WDS_Shortcodes_Base::get_instance()
 *
 * @since  0.1.0
 * @return WDS_Shortcodes_Base  Singleton instance of plugin class.
 */
function wds_shortcodes() {
	return WDS_Shortcodes_Base::get_instance();
}

// Kick it off
add_action( 'plugins_loaded', array( wds_shortcodes(), 'hooks' ) );
