<?php
/**
 * Created by Aurelien
 * Date: 03/07/13
 * Time: 22:42
 */

namespace Library\ApplicationComponent\Log;

use Library\Application;
use Library\ApplicationComponent\ApplicationComponent;

/**
 * Logger
 *
 * @package Library\ApplicationComponent\Log
 * @author Aurelien Mecheri
 */
class Logger extends ApplicationComponent{

    /**
     * @access private
     * @var string $_folder
     */
    private $_folder;

    /**
     * Const PERIOD_VOID
     * Without archive
     */
    const PERIOD_VOID   = 'VOID';
    /**
     * Const PERIOD_DAY
     * Daily archive
     */
    const PERIOD_DAY    = 'DAY';
    /**
     * Const PERIOD_MONTH
     * Monthly archive
     */
    const PERIOD_MONTH  = 'MONTH';
    /**
     * Const PERIOD_YEAR
     * Yearly archive
     */
    const PERIOD_YEAR   = 'YEAR';

    /**
     * Const LEVEL_TRACE
     * ex : In / Out of method
     */
    const LEVEL_TRACE   = 'Trace';
    /**
     * Const LEVEL_DEBUG
     * ex : Display var
     */
    const LEVEL_DEBUG   = 'Debug';
    /**
     * Const LEVEL_INFO
     * ex : Load file, begin / end of long execution
     */
    const LEVEL_INFO    = 'Info';
    /**
     * Const LEVEL_WARN
     * ex : Login error, bad data
     */
    const LEVEL_WARN    = 'Warn';
    /**
     * Const LEVEL_ERROR
     * ex : All exceptions that are not critical
     */
    const LEVEL_ERROR   = 'Error';
    /**
     * Const LEVEL_FATAL
     * ex: DB unavailable, all critical exceptions
     */
    const LEVEL_FATAL   = 'Fatal';
    /**
     * Const LEVEL_GENERAL
     * ex: All other
     */
    const LEVEL_GENERAL = 'General';
    
    /**
     * Construct
     * Check if folder exist (default: ./Applications/{AppName}/Logs/)
     *
     * @param Application $app
     */
    public function __construct(Application $app){
        parent::__construct($app);

        $path = SERVER_ROOT.'Applications'.DIRECTORY_SEPARATOR.APP_NAME.DIRECTORY_SEPARATOR.'Logs'.DIRECTORY_SEPARATOR;
        if(!is_dir($path)){
            mkdir($path);
        }
        $this->_folder = realpath($path);
    }

    /**
     * Returns the path of the log file determined by the parameters $level, $name et $period.
     * (ex: /Applications/{AppName}/Logs/Error/2013/2013_erreur.log)
     * Create the path if not exist
     *
     * @param string $level
     * @param string $name
     * @param string $period
     * @return string
     * @throws \Exception
     **/
    protected function path($level, $name, $period = self::PERIOD_VOID){
        //Create folder of level (./Applications/{AppName}/Logs/{Level}/)
        switch($level){
            case self::LEVEL_GENERAL:
                $path = $this->_folder.'/';
                break;
            case self::LEVEL_TRACE:
            case self::LEVEL_DEBUG:
            case self::LEVEL_INFO:
            case self::LEVEL_WARN:
            case self::LEVEL_ERROR:
            case self::LEVEL_FATAL:
                $path = $this->_folder.'/'.$level.'/';
                if(!is_dir($path)){
                    mkdir($path);
                }
                break;
            default:
                throw new \Exception('Level unsupported');
                break;
        }

        //Create folder of period (./Applications/{AppName}/Logs/{Level}/{Period}/)
        switch($period){
            case self::PERIOD_DAY:
                $current_day = date('Ymd');
                $path = $path.$current_day;
                if( !is_dir($path) ){
                    mkdir($path);
                }
                $logfile = $path.'/'.$current_day.'_'.$name.'.log';
                break;
            case self::PERIOD_MONTH:
                $current_month = date('Ym');
                $path = $path.$current_month;
                if( !is_dir($path) ){
                    mkdir($path);
                }
                $logfile = $path.'/'.$current_month.'_'.$name.'.log';
                break;
            case self::PERIOD_YEAR:
                $current_year = date('Y');
                $path = $path.$current_year;
                if( !is_dir($path) ){
                    mkdir($path);
                }
                $logfile = $path.'/'.$current_year.'_'.$name.'.log';
                break;
            case self::PERIOD_VOID:
                $logfile = $path.$name.'.log';
                break;
            default:
                throw new \Exception('Period unsupported');
                break;
        }
        
        return $logfile;
    }
    
    /**
	 * Save $row in the log file determined by the parameters $level, $name et $period
     *
     * @param string $level
     * @param string $name
     * @param string $row
     * @param string $period
     * @throws \Exception
    **/
    protected function log($level, $name, $row, $period){
        if(empty($name) || empty($row))throw new \Exception("Paramètre manquant");

        $logfile = $this->path($level, $name, $period);

		//Add datetime and level to start line and cr to end line
        $row = date('d/m/Y H:i:s').' ['.$level.'] '.$row."\n";

        $this->write($logfile, $row);
    }
    
    /**
     * Write (append) $row in $logfile
     *
     * @param string $logfile
     * @param string $row
    **/
    protected function write($logfile, $row){
        $file = fopen($logfile,'a+');
        fputs($file, $row);
        fclose($file);
    }

    /**
     * Save $row in the log Trace file determined by the parameters $name et $period
     *
     * @param string $name
     * @param string $row
     * @param string $period
     **/
    public function trace($name, $row, $period = self::PERIOD_VOID){
        $this->log(self::LEVEL_TRACE, $name, $row, $period);
    }

    /**
     * Save $row in the log Debug file determined by the parameters $name et $period
     *
     * @param string $name
     * @param string $row
     * @param string $period
     **/
    public function debug($name, $row, $period = self::PERIOD_VOID){
        $this->log(self::LEVEL_DEBUG, $name, $row, $period);
    }

    /**
     * Save $row in the log Info file determined by the parameters $name et $period
     *
     * @param string $name
     * @param string $row
     * @param string $period
     **/
    public function info($name, $row, $period = self::PERIOD_VOID){
        $this->log(self::LEVEL_INFO, $name, $row, $period);
    }

    /**
     * Save $row in the log Warn file determined by the parameters $name et $period
     *
     * @param string $name
     * @param string $row
     * @param string $period
     **/
    public function warn($name, $row, $period = self::PERIOD_VOID){
        $this->log(self::LEVEL_WARN, $name, $row, $period);
    }

    /**
     * Save $row in the log Error file determined by the parameters $name et $period
     *
     * @param string $name
     * @param string $row
     * @param string $period
     **/
    public function error($name, $row, $period = self::PERIOD_VOID){
        $this->log(self::LEVEL_ERROR, $name, $row, $period);
    }

    /**
     * Save $row in the log Fatal file determined by the parameters $name et $period
     *
     * @param string $name
     * @param string $row
     * @param string $period
     **/
    public function fatal($name, $row, $period = self::PERIOD_VOID){
        $this->log(self::LEVEL_FATAL, $name, $row, $period);
    }

    /**
     * Save $row in the log General file determined by the parameters $name et $period
     *
     * @param string $name
     * @param string $row
     * @param string $period
     **/
    public function general($name, $row, $period = self::PERIOD_VOID){
        $this->log(self::LEVEL_GENERAL, $name, $row, $period);
    }

}
?>