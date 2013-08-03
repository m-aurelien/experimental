<?php
/**
 * Created by Aurelien
 * Date: 30/06/13
 * Time: 22:50
 */

namespace Library\Route;

/**
 * Represents a route
 *
 * @package Library\Route
 * @author Aurelien Mecheri
 */
class Route{
    /**
     * @access private
     * @var string $_url
     */
    private $_url;
    /**
     * @access private
     * @var string $_controller
     */
    private $_controller;
    /**
     * @access private
     * @var string $_action
     */
    private $_action;
    /**
     * @access private
     * @var int $_cache
     */
    private $_cacheDuration;
    /**
     * @access private
     * @var array $_varsNames
     */
    private $_varsNames = array();
    /**
     * @access private
     * @var array $_vars
     */
    private $_vars = array();

    /**
     * Set the params in attributes
     *
     * @param string $url
     * @param string $controller
     * @param string $action
     * @param array $varsNames
     */
    public function __construct($url, $controller, $action, $cacheDuration, array $varsNames){
        $this->setUrl($url);
        $this->setController($controller);
        $this->setAction($action);
        $this->setCacheDuration($cacheDuration);
        $this->setVarsNames($varsNames);
    }

    /**
     * Returns true if there are variables
     *
     * @return bool
     */
    public function hasVars(){
        return !empty($this->_varsNames);
    }

    /**
     * Tries to match the url passed in parameter with the route
     *
     * @param string $url
     * @return bool false | url
     */
    public function match($url){
        if (preg_match('"^'.$this->_url.'$"', $url, $matches)){
            return $matches;
        }else{
            return false;
        }
    }

    /**
     * Setter $_url
     *
     * @param string $url
     */
    public function setUrl($url){
        if (is_string($url)){
            $this->_url = $url;
        }
    }

    /**
     * Getter $_action
     *
     * @return string $_action
     */
    public function action(){
        return $this->_action;
    }

    /**
     * Setter $_action
     *
     * @param string $action
     */
    public function setAction($action){
        if (is_string($action)){
            $this->_action = $action;
        }
    }

    /**
     * Getter $_controller
     *
     * @return string $_controller
     */
    public function controller(){
        return $this->_controller;
    }

    /**
     * Setter $_controller
     *
     * @param string $controller
     */
    public function setController($controller){
        if (is_string($controller)){
            $this->_controller = $controller;
        }
    }

    /**
     * Getter $_cacheDuration
     *
     * @return string $_cacheDuration
     */
    public function cacheDuration(){
        return $this->_cacheDuration;
    }

    /**
     * Setter $_cacheDuration
     *
     * @param int $cacheDuration
     */
    public function setCacheDuration($cacheDuration){
        if (is_int($cacheDuration)){
            $this->_cacheDuration = $cacheDuration;
        }
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
     * Setter $_vars
     *
     * @param array $vars
     */
    public function setVars(array $vars){
        $this->_vars = $vars;
    }

    /**
     * Getter $_varsNames
     *
     * @return array $_varsNames
     */
    public function varsNames(){
        return $this->_varsNames;
    }

    /**
     * Setter $_varsNames
     *
     * @param array $varsNames
     */
    public function setVarsNames(array $varsNames){
        $this->_varsNames = $varsNames;
    }
}