<?php
/**
 * Created by Aurelien.
 * Date: 29/07/13
 * Time: 15:49
 */

namespace Library\ApplicationComponent\Cache;

/**
 * CacheDriver managed by Cache Class
 *
 * @package Library\ApplicationComponent\Cache
 * @author Aurelien Mecheri
 */
class CacheDriver {
    /**
     * @access private
     * @var string $_subfolder
     */
    private $_subfolder = null;
    /**
     * @access private
     * @var string $_file
     */
    private $_file = 'unknown';
    /**
     * @access private
     * @var int $_duration
     */
    private $_duration = 0;
    /**
     * @access private
     * @var timestamp $_timeout
     */
    private $_timeout;
    /**
     * @access private
     * @var bool $_isCache
     */
    private $_isCache = false;
    /**
     * @access private
     * @var array $_vars
     */
    private $_vars = array();

    /**
     * Hydrate some properties
     *
     * @param null $subfolder
     * @param null $file
     * @param null $duration
     * @param null $vars
     */
    public function __construct($subfolder = null, $file = null, $duration = null, $vars = null){
        if($subfolder)  $this->setSubfolder($subfolder);
        if($file)       $this->setFile($file);
        if($duration)   $this->setDuration($duration);
        if($vars)       $this->setVars($vars);
    }

    /**
     * Setter $_subfolder
     *
     * @param string $subfolder
     */
    public function setSubfolder($subfolder){
        $this->_subfolder = $subfolder;
    }

    /**
     * Getter $_subfolder
     *
     * @return null|string $_subfolder
     */
    public function subfolder(){
        return $this->_subfolder;
    }

    /**
     * Setter $_file
     *
     * @param string $file
     */
    public function setFile($file){
        $this->_file = $file;
    }

    /**
     * Getter $_file
     *
     * @return string $_file
     */
    public function file(){
        return $this->_file;
    }

    /**
     * Setter $_duration
     *
     * @param int $duration
     */
    public function setDuration($duration){
        $this->_duration = $duration;
    }

    /**
     * Getter $_duration
     *
     * @return int $_duration
     */
    public function duration(){
        return $this->_duration;
    }

    /**
     * Setter $_timeout
     *
     * @param timestamp $timeout
     */
    public function setTimeout($timeout){
        $this->_timeout = $timeout;
    }

    /**
     * Getter $_timeout
     *
     * @return timestamp
     */
    public function timeout(){
        return $this->_timeout;
    }

    /**
     * Setter $_isCache
     *
     * @param bool $isCache
     */
    public function setIsCache($isCache){
        $this->_isCache = $isCache;
    }

    /**
     * Getter $_isCache
     *
     * @return bool $_isCache
     */
    public function isCache(){
        return $this->_isCache;
    }

    /**
     * Reset $_vars
     */
    public function cleanVars(){
        $this->_vars = array();
    }

    /**
     * Setter $_vars
     *
     * @param array $vars
     */
    public function setVars($vars){
        $this->_vars = $vars;
    }

    /**
     * Adder $_vars
     *
     * @param string $key
     * @param mixed $val
     */
    public function addVar($key, $val){
        $this->_vars[$key] = $val;
    }

    /**
     * Getter $_vars
     *
     * @return array $_vars
     */
    public function vars(){
        return $this->_vars;
    }

    /**
     * Getter $_vars by key
     *
     * @param string $key
     * @return mixed $_vars[$key]
     */
    public function get($key){
        return $this->_vars[$key];
    }
}