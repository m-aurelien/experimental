<?php
/**
 * Created by Aurelien
 * Date: 08/08/13
 * Time: 10:45
 */

namespace Library\ApplicationComponent\Log;


use Library\Application;
use Library\ApplicationComponent\ApplicationComponent;

/**
 * Stats
 *
 * @package Library\ApplicationComponent\Log
 * @author Aurelien Mecheri
 */
class Stats extends ApplicationComponent{
    /**
     * @var string
     */
    private $_folder;

    /**
     * Construct
     * Check if folder exist (default: ./Applications/{AppName}/Stats/)
     *
     * @param Application $app
     */
    public function __construct(Application $app){
        parent::__construct($app);

        $path = SERVER_ROOT.'Applications'.DIRECTORY_SEPARATOR.APP_NAME.DIRECTORY_SEPARATOR.'Stats'.DIRECTORY_SEPARATOR;
        if(!is_dir($path)){
            mkdir($path);
        }
        $this->_folder = realpath($path);
    }

    /**
     * Update Global Visit
     */
    public function GlobalVisit(){
        return $this->_visit('globalvisit');
    }

    /**
     * Update Daily Visit
     */
    public function DailyVisit(){
        return $this->_visit('dailyvisit-'.date('d-m-Y'));
        //TODO : Save in DB daily visit every day
    }

    /**
     * Increment file
     *
     * @param string $file
     * @return string $nbVisit
     */
    private function _visit($file){
        $completeFile = $this->_folder.DIRECTORY_SEPARATOR.$file.'.txt';
        $nbVisit = 0;

        if(file_exists($completeFile)){
            $file = fopen($completeFile,'r+');
            if($line = fgets($file)){
                $nbVisit = $line;
            }
            fclose($file);
        }

        $file = fopen($completeFile,'w+');
            $nbVisit++;
            fputs($file, $nbVisit);
        fclose($file);

        return $nbVisit;
    }
}