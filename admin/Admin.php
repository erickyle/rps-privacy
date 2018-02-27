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
	 * Adds top-level admin menu and the plugin submenu.
	 *
	 * @since 				1.0.0
	 */
	public function rps_admin_menu() {
				
		global $menu;
		
		$rps_admin_menu_handle = 'rps-admin-menu';
		$rps_admin_menu_is_set = false;
		
		foreach ( $menu as $key => $menu_item ) {
			if ( in_array( $rps_admin_menu_handle, $menu_item ) ) {
				$rps_admin_menu_is_set = true;
				break;
			}
		}
		
		//adds the top-level menu if not already set
		if ( ! $rps_admin_menu_is_set ) {
			add_menu_page( '', 'RPS', 'manage_options', $rps_admin_menu_handle );
		}
		
		//adds the plugin settings sub-menu item and removes the RPS prefix
		add_submenu_page( $rps_admin_menu_handle, $this->plugin->get_plugin_display_name(), str_replace( 'RPS ', '', $this->plugin->get_plugin_display_name() ), 'manage_options', Redux::getArg( Options::get_opt_name(), 'page_slug' ) );
		
		//removes the sub-menu item that is a duplicate of the top-level menu item
		remove_submenu_page( $rps_admin_menu_handle, $rps_admin_menu_handle );
				
		//removes the menu item set by the Redux Framework
		remove_menu_page( Redux::getArg( Options::get_opt_name(), 'page_slug' ) );
		
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
