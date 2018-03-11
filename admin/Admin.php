<?php

namespace rpsPluginBoilerplate\admin;
use \rpsPluginBoilerplate\admin\options\Options;
use \Redux;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @since 				1.0.0
 * @package 			rps-plugin-boilerplate
 * @subpackage 			rps-plugin-boilerplate/admin
 * @author 				Red Pixel Studios <support@redpixel.com>
 */
class Admin {

	/**
	 * The plugin.
	 *
	 * @since 				1.0.0
	 * @var 				object 				$plugin 				\rpsPluginBoilerplate\includes\Plugin
	 * @access 				private
	 */
	private $plugin;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 				1.0.0
	 * @param 				object 				$plugin 				\rpsPluginBoilerplate\includes\Plugin
	 */
	public function __construct( $plugin ) {

		$this->plugin = $plugin;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since 				1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin->get_plugin_name(), plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), $this->plugin->get_plugin_version(), 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since 				1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin->get_plugin_name(), plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery' ), $this->plugin->get_plugin_version(), false );

	}
	
}
