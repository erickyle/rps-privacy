<?php

namespace rpsPluginBoilerplate;
use \rpsPluginBoilerplate\includes\Plugin;
use \rpsPluginBoilerplate\includes\Activator;
use \rpsPluginBoilerplate\includes\Deactivator;

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link 				https://redpixel.com
 * @since 				1.0.0
 * @package 			rps-plugin-boilerplate
 *
 * @wordpress-plugin
 * Plugin Name: 		RPS Plugin Boilerplate
 * Plugin URI: 			https://redpixel.com
 * Description: 		Adds functionality to the active WordPress theme for the domain.
 * Version: 			1.0.0
 * Author: 				Red Pixel Studios
 * Author URI: 			https://redpixel.com
 * License: 			GPLv3
 * License URI: 		http://www.gnu.org/licenses/gpl-3.0-standalone.html
 * Text Domain: 		rps-plugin-boilerplate
 * Domain Path: 		/languages
 */

if ( ! class_exists( 'ReduxFramework' ) and file_exists( dirname( __FILE__ ) . '/admin/ReduxFramework/redux-framework.php' ) ) {
	require_once( dirname( __FILE__ ) . '/admin/ReduxFramework/redux-framework.php' );
}

/** Uncomment to use EDD
if ( !class_exists( '\rps\components\easyDigitalDownloads\v1_1_4\EasyDigitalDownloads' ) ) {
	require_once( dirname( __FILE__ ) . '/rps/components/easyDigitalDownloads/autoload.php' );
}
use \rps\components\easyDigitalDownloads\v1_1_4\EasyDigitalDownloads;

if ( !class_exists( '\rps\components\tgmPluginActivation\v1_0_0\TGMPluginActivator' ) ) {
	require_once( dirname( __FILE__ ) . '/rps/components/tgmPluginActivation/autoload.php' );
}
use \rps\components\tgmPluginActivation\v1_0_0\TGMPluginActivator;
*/

/**
 * Abort if this file is called directly.
 *
 * @since 				1.0.0
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Automatically load required classes.
 *
 * @since 				1.0.0
 */
spl_autoload_register( function ( $class ) {
	// Make sure that the class being loaded is in the right namespace
	$namespace = __NAMESPACE__ . '\\';
	
	$class_parts = explode( '\\', $class );
	array_shift( $class_parts );
	
	if ( substr( $class, 0, strlen( $namespace ) ) !== $namespace ) {
		return;
	}
	
	// Locate and load the file that contains the class
	$path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . implode( DIRECTORY_SEPARATOR, $class_parts ) . '.php';
		
	if ( file_exists( $path ) ) {
		require( $path );
	}

});

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/activator.class.php
 *
 * @since 				1.0.0
 */
function activate() {
	Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/deactivator.class.php
 *
 * @since 				1.0.0
 */
function deactivate() {
	Deactivator::deactivate();
}

register_activation_hook( __FILE__, __NAMESPACE__ . '\activate' );
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 				1.0.0
 */
function run() {
	$plugin = new Plugin( '1.0.0' );
	
/** Uncomment to use components

	$edd = new EasyDigitalDownloads();
	$tgm = new TGMPluginActivator();
	
	// configure TGM
	$tgm->setEDD( $edd );
	
	$rps_registry = array(
		'name'         	=> 'RPS Registry',
		'slug'         	=> 'rps-registry',
		'source'      	=> 'https://s3-us-west-2.amazonaws.com/redpixelstore/rps-registry.zip',
		'required'     	=> false,
		'external_url' 	=> 'https://store.redpixel.com/downloads/rps-registry/',
		'edd_ids'		=> array( 666, 659 )
	);
	
	$tgm->addPlugin( $rps_registry );
	
	$plugin->add_plugin_component( $edd );
	$plugin->add_plugin_component( $tgm );

*/
	
	$plugin->init();
	$plugin->run();

}
run();
