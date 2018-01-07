<?php
/**
 * @version 1.0
 * @author  Maksym Prihodko
 * @package wp-code-deploy
 */
/*
Plugin Name: WP Code Deploy
Plugin URI: 
Description: 
Version: 1.0
Author: Maksym Prihodko
Author URI: 
License: GPLv2 or later
Text Domain: wp-code-deploy
*/


/* check is defined ABSPATH */
if( !defined( 'ABSPATH' ) )
{
	exit( 'ABSPATH is not defined' );
}

/* Define WPCD_VERSION */
if( !defined( 'WPCD_VERSION' ) )
{
	define( 'WPCD_VERSION', '1.0' );
}

/* Define WPCD_PLUGIN_DIR */
if( !defined( 'WPCD_PLUGIN_DIR' ) )
{
	define( 'WPCD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/* Define WPCD_PLUGIN_URI*/
if( !defined( 'WPCD_PLUGIN_URI' ) )
{
	define( 'WPCD_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
}

/* Define WPCD_PLUGIN_KEYS_DIR*/
if( !defined( 'WPCD_PLUGIN_KEYS_DIR' ) )
{
	define( 'WPCD_PLUGIN_KEYS_DIR', DIRECTORY_SEPARATOR.'home'.DIRECTORY_SEPARATOR.trim(shell_exec( 'whoami' )).DIRECTORY_SEPARATOR.'.ssh'.DIRECTORY_SEPARATOR);
}

/* Define WPCD_PLUGIN_KEYS_DIR*/
if( !defined( 'WPCD_PLUGIN_LOGS_DIR' ) )
{
	define( 'WPCD_PLUGIN_LOGS_DIR', plugin_dir_path( __FILE__ ).'logs'.DIRECTORY_SEPARATOR);
}

/* Define WPCD_PLUGIN_BASENAME */
if( !defined( 'WPCD_PLUGIN_BASENAME' ) )
{
	define( 'WPCD_PLUGIN_BASENAME',  plugin_basename( __FILE__ ) );
}

/* Define WPCD_MINIMUM_WP_VERSION */
if( !defined( 'WPCD_MINIMUM_WP_VERSION' ) )
{
	define( 'WPCD_MINIMUM_WP_VERSION', '4.0' );
}

if( file_exists(  ABSPATH . 'wp-admin'.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'plugin.php' ) )
{
	require_once( ABSPATH . 'wp-admin'.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'plugin.php' );
}

if( !file_exists( WPCD_PLUGIN_DIR."classes".DIRECTORY_SEPARATOR."class-WPCD.php" ))
{
	deactivate_plugins( WPCD_PLUGIN_BASENAME );
	wp_die( '<strong>'.__( "ERROR:" ).'</strong> <span>'.__( "Class <b>WPCD</b> doesn't exists" ).'</span>' );
}

require_once WPCD_PLUGIN_DIR."classes".DIRECTORY_SEPARATOR."class-WPCD.php";

add_action( 'wp_loaded', array( 'WPCD', 'wpcd_autoload' ) );
register_activation_hook( __FILE__, array( 'WPCD', 'wpcd_autoload' ) );
WPCD::load_class( 'Logs' );
WPCD::load_class( 'Curl', $autoload = true );
WPCD::load_class( 'Admin' );
WPCD::load_class( 'Ajax', $autoload = true );
WPCD::load_class( 'Deploy', $autoload = true );
WPCD_Admin::run();