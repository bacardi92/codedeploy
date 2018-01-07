<?php 
/**
 * @since      1.0
 * @access     public
 * @author  Maksym Prihodko
 * @package wp-code-deploy
 * @subpackage wp-code-deploy-classes
 */

class WPCD_Logs  
{

    public static function writeLog( $log )
	{
	    if(!$log || empty($log)){
	        return false;
        }
		$file = fopen( WPCD_PLUGIN_LOGS_DIR.date("Y-m").".log", "a");
		fwrite($file, $log."\r\n");
		fclose($file);
		return true;
	}

	public static function getLogsList()
	{
		$logFiles = array();
		$filesDirectory = scandir( WPCD_PLUGIN_LOGS_DIR );
		foreach ( $filesDirectory as $filename ) {
			if( preg_match( "/[0-9]{4}-[0-9]{2}.log/", $filename ) )
			{
				$logFiles[$filename] = WPCD_PLUGIN_LOGS_DIR.$filename;
			}
		}
		return $logFiles;
	}

	public static function createLogFile()
    {
        if(file_exists(WPCD_PLUGIN_LOGS_DIR.date("Y-m").".log")){
            return false;
        }
        return self::writeLog('Logfile Created');
    }

    public static function getLogFileContent($logFile)
    {
    	if(file_exists($logFile)){
            $response['logs'] = file_get_contents($logFile);
        }else{
            $response['message'] = WPCD::admin_danger( __( "Incorrect path to file!" ), false);
        }
        return $response;
    } 

}