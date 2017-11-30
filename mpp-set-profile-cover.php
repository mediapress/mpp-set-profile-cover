<?php
/**
 * Main plugin loader file
 *
 * @package mpp-set-profile-cover
 */

/**
 * Plugin Name: MediaPress Set Profile Cover
 * Plugin URI: https://buddydev.com/plugins/mpp-set-profile-cover/
 * Version: 1.0.0
 * Author: BuddyDev Team
 * Author URI: https://buddydev.com
 * Description: This plugin is an addon for MediaPress and allow user to set their photo as profile cover
 *
 * License: GPL2 or Above
 */

/**
 * Class MPP_Set_Profile_Cover_Helper
 */
class MPP_Set_Profile_Cover_Helper {
	/**
	 * Singleton Instance
	 *
	 * @var MPP_Set_Profile_Cover_Helper
	 */
	private static $instance = null;

	/**
	 * Plugin directory path
	 *
	 * @var string
	 */
	private $path;

	/**
	 * The constructor.
	 */
	private function __construct() {
		$this->setup();
	}

	/**
	 * Get the singleton instance
	 *
	 * @return MPP_Set_Profile_Cover_Helper
	 */
	public static function get_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Setup hooks
	 */
	private function setup() {

		$this->path = plugin_dir_path( __FILE__ );

		add_action( 'mpp_loaded', array( $this, 'load' ) );
		add_action( 'mpp_init', array( $this, 'load_textdomain' ) );
	}

	/**
	 * Load required files
	 */
	public function load() {

		if ( ! function_exists( 'buddypress' ) || (bool) bp_get_option( 'bp-disable-cover-image-uploads' ) ) {
			return;
		}

		$files = array(
			'core/mpp-spc-template-helper.php',
			'core/mpp-spc-hooks.php',
		);

		foreach ( $files as $file ) {
			require_once $this->path . $file;
		}
	}

	/**
	 * Load plugin translations
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'mpp-set-profile-cover', false, basename( dirname( __FILE__ ) ) . '/languages/' );
	}
}

MPP_Set_Profile_Cover_Helper::get_instance();

