<?php 
/**
 * @since 1.0
 * @access public
 * @author Maksym Prihodko
 * @package wp-code-deploy
 * @subpackage wp-code-deploy-classes
 */

class WPCD
{

	public static $message;

	public function __construct(){
        WPCD_Logs::createLogFile();
    }

	/**
	 * Class Loader
	 *
	 * @since  1.0
	 * @access public
	 * @static
     * @param string $file
     * @param bool $autoload
     * @param null $val
     */
	public static function load_class( $file='index', $autoload=false, $val=null )
	{
		$path =  WPCD_PLUGIN_DIR.'classes'.DIRECTORY_SEPARATOR.'class-'.ucfirst( $file ).'.php';
		if( file_exists( $path ) )
		{
			include $path;
		}else{
			self::admin_danger( '<strong>'.__( "ERROR:" ).'</strong><span>'.__( "File" ).' '.$path.' '.__( "doesn't exists" ).'</span>' );
		}
		if( !class_exists( "WPCD_".ucfirst( $file ) ) )
		{
			wp_die( "Class <b>WPCD_".ucfirst( $file )."</b> doesn't exists" );
		}
		if( $autoload )
		{
			$className = "WPCD_".ucfirst( $file );
			$GLOBALS[$className] = new $className( $val );
		}
	}

    /**
     * Service Loader
     *
     * @since  1.0
     * @access public
     * @static
     * @param string $file
     * @param bool $autoload
     * @param null $val
     */
    public static function load_service( $file='index', $autoload=false, $val=null )
    {
        $path =  WPCD_PLUGIN_DIR.'services'.DIRECTORY_SEPARATOR.ucfirst( $file ).'_Service.php';
        if( file_exists( $path ) )
        {
            include $path;
        }else{
            self::admin_danger( '<strong>'.__( "ERROR:" ).'</strong><span>'.__( "File" ).' '.$path.' '.__( "doesn't exists" ).'</span>' );
        }
        if( !class_exists( ucfirst( $file )."_Service" ) )
        {
            wp_die( "Class <b>".ucfirst( $file )."_Service</b> doesn't exists" );
        }
        if( $autoload )
        {
            $className = ucfirst( $file )."_Service";
            return new $className( $val );
        }
    }

	/**
	 * View Loader
	 *
	 * @since  1.0
	 * @access public
	 * @static
     * @param string $file
     * @param array $data
     */
	public static function load_view( $file='index', $data=array() )
	{
		if( count( $data ) )
		{
			extract( $data );
		}
		$path =  WPCD_PLUGIN_DIR.'view'.DIRECTORY_SEPARATOR.'template-'.ucfirst( $file ).'.php';
		if( file_exists( $path ) )
		{
			include $path;
		}else{
			self::admin_danger( '<strong>'.__( "ERROR:" ).' </strong><span>'.__( "File" ).' '.$path.' '.__( "doesn't exists" ).'</span>' );
		}
	}


	/**
	 * Admin Error Notificator 
	 *
	 * @since  1.0
	 * @access public
	 * @static
     * @param string $message
     * @param bool $echo
     * @return string
     */
	public static function admin_danger( $message='', $echo=true )
	{
		self::$message = $message;
			 
		$output = '
		<div id="message-'.time().'" class="error notice is-dismissible">
			<p>'.self::$message.'</p>
		</div>
		';
		if( $echo )
		{
			echo $output;
		}else
		{
			return $output;
		}
	}


	/**
	 * Admin Success Notificator 
	 *
	 * @since  1.0
	 * @access public
	 * @static
     * @param string $message
     * @param bool $echo
     * @return string
     */

	public static function admin_success( $message='', $echo=true )
	{
		self::$message = $message;
		$output = '
		<div id="message-'.time().'" class="updated notice is-dismissible">
			<p>'.self::$message.'</p>
		</div>
		';
		if( $echo )
		{
			echo $output;
		}else
		{
			return $output;
		}
		
	}


	/**
	 * Autoload Plugin 
	 *
	 * @since  1.0
	 * @access public
	 * @return mixed
	 */

	public static function wpcd_autoload()
	{

		self::load_class( 'Requirements' );
		$error = array();
		if( class_exists( 'WPCD_Requirements' ) )
		{
			if( !WPCD_Requirements::is_os_supported() )
			{
				$error[] = '<strong>'.__( "ERROR:" ).' </strong> <span>'.__( "Your OS not supported this plugin" ).'</span>';
			}
			if( !WPCD_Requirements::is_php_supported() )
			{
				$error[] = '<strong>'.__( "ERROR:" ).' </strong> <span>'.__( "Plugin need PHP 5.5.9 or higher" ).'</span>';
			}
			if( !WPCD_Requirements::is_git_supported() )
			{
				$error[] = '<strong>'.__( "ERROR:" ).' </strong> <span>'.__( "Please install git on your server or contact your server administrator" ).'</span>';
			}
			if( !WPCD_Requirements::is_wp_supported() )
			{
				$error[] = '<strong>'.__( "ERROR:" ).' </strong> <span>'.__( "Plugin need Wordpress 4.0.0 or higher" ).'</span>';
			}
		}else{
			$error[] = '<strong>'.__( "ERROR:" ).' </strong> <span>'.__( "Class <b>WPCD_Requirements</b> doesn't exists" ).'</span>';
		}
		if( count( $error ) )
		{
			if( function_exists( 'deactivate_plugins' ) ){
				deactivate_plugins( WPCD_PLUGIN_BASENAME );
			}
			wp_die( implode( "<br>", $error ) );
		}
	}

	public static function which_repo()
    {
        $repository = get_option( "_wpcd_repository" );
        if(stripos($repository, 'bitbucket')){
            return 'bitbucket';
        }elseif(stripos($repository, 'github')){
            return 'github';
        }else{
            return false;
        }
    }
}