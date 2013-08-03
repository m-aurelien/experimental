<?php
/**
 * Created by Aurelien
 * Date: 30/06/13
 * Time: 22:32
 */

namespace Library;


use Library\ApplicationComponent\Auth\User;
use Library\ApplicationComponent\Config\Config;
use Library\ApplicationComponent\Database\PDOFactory;
use Library\ApplicationComponent\Http\HTTPRequest;
use Library\ApplicationComponent\Http\HTTPResponse;
use Library\ApplicationComponent\I18n\I18nManager;
use Library\ApplicationComponent\Log\Logger;
use Library\ApplicationComponent\Cache\Cache;
use Library\Route\Router;

/**
 * Application core
 *
 * @package Library
 * @author Aurelien Mecheri
 * @abstract
 */
abstract class Application
{
    /**
     * @access private
     * @var string $_name
     */
    private $_name;
    /**
     * @access private
     * @var HTTPRequest $_httpRequest
     */
    private $_httpRequest;
    /**
     * @access private
     * @var HTTPResponse $_httpResponse
     */
    private $_httpResponse;
    /**
     * @access private
     * @var Config $_config
     */
    private $_config;
    /**
     * @access private
     * @var Logger $_logger
     */
    private $_logger;
    /**
     * @access private
     * @var Cache $_cache
     */
    private $_cache;
    /**
     * @access private
     * @var User $_user
     */
    private $_user;
    /**
     * @access private
     * @var I18nManager $_i18n
     */
    private $_i18n;
    /**
     * @access private
     * @var PDOFactory $_pdo
     */
    private $_pdo;

    /**
     * Instance all ApplicationComponant
     */
    public function __construct(){
        $this->_httpRequest  = new HTTPRequest($this);
        $this->_httpResponse = new HTTPResponse($this);
        $this->_config       = new Config($this);
        $this->_logger       = new Logger($this);
        $this->_cache        = new Cache($this);
        $this->_user         = new User($this);
        $this->_i18n         = new I18nManager($this);
        $this->_pdo          = new PDOFactory($this);
    }

    /**
     * Return instance of good controller according to the route
     *
     * @return Controller controller
     */
    public function controller(){
        $router = new Router();
        $router->addRoutesConfig($this->name());

        try{
            $matchedRoute = $router->route($this->httpRequest()->requestURI());
        }catch (\RuntimeException $e){
            if ($e->getCode() == Router::NO_ROUTE){
                $this->httpResponse()->redirect404();
            }
        }

        $_GET = array_merge($_GET, $matchedRoute->vars());

        $controllerClass = 'Applications\\'.$this->name().'\\Controllers\\'.$matchedRoute->controller().'Controller';
        return new $controllerClass($this, $matchedRoute->controller(), $matchedRoute->action(), $matchedRoute->cacheDuration());
    }

    /**
     * Run
     *
     * @abstract
     */
    abstract public function run();

    /**
     * Setter $_name
     *
     * @param string $name
     */
    public function setName($name){
        $this->_name = $name;
    }

    /**
     * Getter $_name
     *
     * @return string $_name
     */
    public function name(){
        return $this->_name;
    }

    /**
     * Getter $_httpRequest
     *
     * @return HTTPRequest $_httpRequest
     */
    public function httpRequest(){
        return $this->_httpRequest;
    }

    /**
     * Getter $_httpResponse
     *
     * @return HTTPResponse $_httpResponse
     */
    public function httpResponse(){
        return $this->_httpResponse;
    }

    /**
     * Getter $_config
     *
     * @return Config $_config
     */
    public function config(){
        return $this->_config;
    }

    /**
     * Getter $_logger
     *
     * @return Logger $_logger
     */
    public function logger(){
        return $this->_logger;
    }

    /**
     * Getter $_logger
     *
     * @return Cache $_cache
     */
    public function cache(){
        return $this->_cache;
    }

    /**
     * Getter $_user
     *
     * @return User $_user
     */
    public function user(){
        return $this->_user;
    }

    /**
     * Getter $_i18n
     *
     * @return I18nManager $_i18n
     */
    public function i18n(){
        return $this->_i18n;
    }

    /**
     * Getter $_pdo
     *
     * @return PDOFactory $_pdo
     */
    public function pdo(){
        return $this->_pdo;
    }

}