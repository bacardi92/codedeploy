<?php 
/**
 * @since      1.0
 * @access     public
 * @author  Maksym Prihodko
 * @package wp-code-deploy
 * @subpackage wp-code-deploy-classes
 */

class WPCD_Requirements 
{

	/**
	 * @since  1.0
	 * @access public
	 * @static
	 * @return bool
	 */

	public static function is_os_supported()
	{
		if( stripos( PHP_OS,'win' ) )
		{
			return false;
		}
		return true;
	}

	/**
	 * @since  1.0
	 * @access public
	 * @static
	 * @return bool
	 */

	public static function is_wp_supported()
	{
		global $wp_version;
		if( version_compare( $wp_version, WPCD_MINIMUM_WP_VERSION, '<' ) )
		{
			return false;
		}
		return true;
	}

	/**
	 * @since  1.0
	 * @access public
	 * @static
	 * @return bool
	 */

	public static function is_php_supported()
	{
		if ( version_compare( PHP_VERSION, '5.5.9', '<' ) ) 
		{
			return false;
		}
		return true;
	}

	/**
	 * @since  1.0
	 * @access public
	 * @static
	 * @return bool
	 */

	public static function is_git_supported()
	{
		if ( empty( exec('which git') ) ) 
		{
			return false;
		}
		return true;
	}

}