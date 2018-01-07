<?php 
/**
 * @since      1.0
 * @access     public
 * @author  Maksym Prihodko
 * @package wp-code-deploy
 * @subpackage wp-code-deploy-classes
 */

class WPCD_Ajax extends WPCD
{	

	private $logs;
	/**
	 * Register Ajax Hooks 
	 *
	 * @since  1.0
	 * @access public
	 * @return void
	 */

	public function __construct()
	{
		parent::__construct();
		add_action( "wp_ajax_save_git_user_data", array( $this, "save_git_user_data" ) );
		add_action( "wp_ajax_test_connection", array( $this, "test_connection" ) );
		add_action( "wp_ajax_save_git_creds", array( $this, "save_git_creds") );
		add_action( "wp_ajax_request_log_file", array( $this, "request_log_file") );
	}

	
	/**
	 * Ajax Save Git User 
	 *
	 * @since  1.0
	 * @access public
	 * @param POST
	 * @return void
	 */

	public function save_git_user_data()
	{
		$response['message'] = '';
		if( isset( $_POST['username'] ) )
		{
			$username = sanitize_text_field( $_POST['username'] );
		}
		if( isset( $_POST['userEmail'] ) )
		{
            $userEmail = filter_var( sanitize_text_field( $_POST['userEmail'] ), FILTER_VALIDATE_EMAIL );
		}
		if( isset( $_POST['repository'] ) )
        {
            $repository = sanitize_text_field( $_POST['repository'] );
        }
        if( isset( $_POST['connectionType'] ) ){
		    $connection = sanitize_text_field( $_POST['connectionType'] );
        }

		if( !$username || empty( $username ) )
		{
			$response['message'] .= self::admin_danger( __( "Invalid Username!" ), false );
			/*Log*/
			WPCD_Logs::writeLog( date( "Y-m-d H:i:s" ).'  invalid user name. Update failed.' );
		}
		if( !$userEmail || empty( $userEmail ) )
		{
			$response['message'] .= self::admin_danger( __( "Invalid User Email!" ), false );
			/*Log*/
			WPCD_Logs::writeLog( date( "Y-m-d H:i:s" ).'  invalid user email. Update failed.' );
		}
		if( !$repository || empty( $repository ) )
		{
            $response['message'] .= self::admin_danger( __( "Invalid Repository Path!" ), false );
            /*Log*/
            WPCD_Logs::writeLog( date( "Y-m-d H:i:s" ).'  invalid repository path. Update failed.' );
        }
        if( !$connection || empty( $connection ) ){
		    $connection = 'https';
        }

		if( empty($response['message']) )
		{
			update_option( "_wpcd_username", $username, "yes" );
			update_option( "_wpcd_useremail", $userEmail, "yes" );
            update_option( "_wpcd_repository", $repository, "yes" );
            update_option( "_wpcd_connection", $connection, "yes" );

			$response['message'] .= self::admin_success( __( "Userdata has been successful saved!" ), false );
			/*Log*/
			WPCD_Logs::writeLog( date( "Y-m-d H:i:s" ).'  updated local user data' );
		}
		echo json_encode( $response );
		wp_die();
	}

	public function test_connection()
    {
        $connectionType = get_option('_wpcd_connection');
        if($connectionType == 'ssh' ){
            exec('git ls-remote '.get_option('_wpcd_repository'), $output, $return_var);
            if(count($output) && $return_var == 0){
                $isLogged = true;
            }else{
                $isLogged = false;
            }
        }else{
            $username = get_option( "_wpcd_creds_username" );
            $password = get_option( "_wpcd_creds_password" );
            if(self::which_repo() == 'bitbucket'){
                $isLogged = WPCD_Curl::loginBitbucket($username, $password);
            }else {
                $isLogged = WPCD_Curl::loginGithub($username, $password);
            }
        }
        if($isLogged){
            $response['message'] = self::admin_success( __( "Test Passed!" ), false );
        }else{
            $response['message'] = self::admin_danger( __( "Test Failed!" ), false );
        }
        echo json_encode( $response );
        wp_die();
    }

    public function save_git_creds()
    {
        $response['message'] = '';
        if( isset($_POST['username']) && isset($_POST['password']) )
        {
            $username = sanitize_text_field( $_POST['username'] );
            $password = $_POST['password'];
        }
        if( !$username || empty( $username ) )
        {
            $response['message'] .= self::admin_danger( __( "Invalid Username!" ), false );
            /*Log*/
            WPCD_Logs::writeLog( date( "Y-m-d H:i:s" ).'  invalid user name. Update failed.' );
        }
        if( !$password || empty( $password ) )
        {
            $response['message'] .= self::admin_danger( __( "Invalid User Email!" ), false );
            /*Log*/
            WPCD_Logs::writeLog( date( "Y-m-d H:i:s" ).'  invalid user email. Update failed.' );
        }
        if( empty($response['message']) ) {
            update_option("_wpcd_creds_username", $username, "yes");
            update_option("_wpcd_creds_password", $password, "yes");
            $response['message'] .= self::admin_success( __( "User Creds has been successful saved!" ), false );

            /*Log*/
            WPCD_Logs::writeLog( date( "Y-m-d H:i:s" ).'  updated https user creds' );
        }
        echo json_encode( $response );
        wp_die();
    }

    public function request_log_file(){
        $response['message'] = '';
        if(isset($_POST['logFile']) && !empty($_POST['logFile'])){
            $response = WPCD_Logs::getLogFileContent($_POST['logFile']);
        }else{
            $response['message'] .= self::admin_danger( __( "Incorrect path to file!" ), false);
        }
        echo json_encode($response);
        wp_die();
    }
}

