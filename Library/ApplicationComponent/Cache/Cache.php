<?php
/**
 * Created by Aurelien
 * Date: 29/07/13
 * Time: 10:40
 */

namespace Library\ApplicationComponent\Cache;

use Library\Application;
use Library\ApplicationComponent\ApplicationComponent;

/**
 * Cache Manager
 *
 * @package Library\ApplicationComponent\Cache
 * @author Aurelien Mecheri
 */
class Cache extends ApplicationComponent{
    /**
     * @access private
     * @var bool $_disable
     */
    private $_disable = true;
    /**
     * @access private
     * @var string $_folder
     */
    private $_folder;
    /**
     * @access private
     * @var array $_drivers
     */
    private $_drivers = array();

    /**
     * Specifies folder
     *
     * @param Application $app
     */
    public function __construct(Application $app){
        parent::__construct($app);

        $path = SERVER_ROOT.'Applications'.DIRECTORY_SEPARATOR.APP_NAME.DIRECTORY_SEPARATOR.'Caches'.DIRECTORY_SEPARATOR;
        if(!is_dir($path)){
            mkdir($path);
        }
        $this->_folder = realpath($path);
    }

    /**
     * Load cache by key
     *
     * @param string $driverKey
     * @return bool
     */
    public function load($driverKey) {
        if(!($driver = $this->get($driverKey))) return false;

        $path = $this->_folder.DIRECTORY_SEPARATOR;
        if($driver->subfolder()) $path .= $driver->subfolder().DIRECTORY_SEPARATOR;
        $path .= $driver->file().'.php';

        if(!$this->isDisable() && file_exists($path)) {
            require $path;

            if($driver->timeout() > time()) {
                $driver->setIsCache(true);
                return true;
            }
        }
        $driver->setIsCache(false);
        return false;
    }

    /**
     * Load all caches
     */
    public function loadAll(){
        foreach ($this->drivers() as $key => $driver) {
            $this->load($key);
        }
    }

    /**
     * Save cache by key
     *
     * @param string $driverKey
     * @return int | null | false
     */
    public function save($driverKey) {
        if(!($driver = $this->get($driverKey))) return false;

        $path = $this->_folder.DIRECTORY_SEPARATOR;
        if($driver->subfolder()){
            $path .= $driver->subfolder().DIRECTORY_SEPARATOR;
            if(!is_dir($path)){
                mkdir($path);
            }
        }
        $path .= $driver->file().'.php';

        $cache_file = "<?php\n";
        $cache_file .= "/**\n";
        $cache_file .= " * CACHE FILE NAME : ". $driver->file() ."\n";
        $cache_file .= " * GENERATE TIME : ". date('Y-m-d H:i:s') ."\n";
        $cache_file .= " */\n\n";

        $driver->setTimeout(time() + $driver->duration());

        $cache_file .= "//Timeout : ".date('Y-m-d H:i:s', $driver->timeout())."\n";
        $cache_file .= '$driver->setTimeout('.$driver->timeout().");\n\n";
        $cache_file .= "//Content\n";
        $cache_file .= '$driver->setVars('.var_export($driver->vars(), true).');';
        $cache_file .= "\n\n";

        return file_put_contents($path, $cache_file);
    }

    /**
     * Save all caches
     */
    public function saveAll(){
        foreach ($this->drivers() as $key => $driver) {
            $this->save($key);
        }
    }

    /**
     * Clean file by key
     *
     * @param string $driverKey
     */
    public function cleanFile($driverKey){
        $driver = $this->get($driverKey);

        $path = $this->_folder.DIRECTORY_SEPARATOR;
        if($driver->subfolder()) $path .= $driver->subfolder().DIRECTORY_SEPARATOR;
        $path .= $driver->file().'.php';

        if(file_exists($path)){
            unlink($path);
        }
    }

    /**
     * Clean all files
     */
    public function cleanAllFiles(){
        foreach ($this->drivers() as $key => $driver) {
            $this->cleanFile($key);
        }
    }

    /**
     * Disable cache
     */
    public function disable(){
        $this->_disable = true;
    }

    /**
     * Enable cache
     */
    public function enable(){
        $this->_disable = false;
    }

    /**
     * Getter $_disable
     *
     * @return bool $_disable
     */
    public function isDisable(){
        return $this->_disable;
    }

    /**
     * Adder $_drivers
     *
     * @param string $key
     * @param CacheDriver $driver
     */
    public function addDriver($key, CacheDriver $driver){
        $this->_drivers[$key] = $driver;
    }

    /**
     * Getter $_drivers
     *
     * @return array $_drivers
     */
    public function drivers(){
        return $this->_drivers;
    }

    /**
     * Exist key in $_drivers
     *
     * @param string $key
     * @return bool
     */
    public function is($key){
        if(array_key_exists($key, $this->_drivers)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Getter $_drivers by key
     *
     * @param string $key
     * @return CacheDriver $_drivers[$key]
     */
    public function get($key){
        if(array_key_exists($key, $this->_drivers)){
            return $this->_drivers[$key];
        }else{
            return null;
        }

    }
}