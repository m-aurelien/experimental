<?php
/**
 * Created by Aurelien
 * Date: 30/06/13
 * Time: 22:28
 */

namespace Library\ApplicationComponent\Http;


use Library\ApplicationComponent\ApplicationComponent;
use Library\ApplicationComponent\Body\BackboneComponent\Skin;

/**
 * HTTPResponse
 *
 * @package Library\ApplicationComponent\Http
 * @author Aurelien Mecheri
 */
class HTTPResponse extends ApplicationComponent{
    /**
     * @access private
     * @var
     */
    private $_skin;

    /**
     * Add header
     *
     * @param string $header
     */
    public function addHeader($header){
        header($header);
    }

    /**
     * To redirect
     *
     * @param string $location
     */
    public function redirect($location){
        header('Location: '.$location);
        exit();
    }

    /**
     * To redirect 404
     */
    public function redirect404(){
        $this->addHeader('HTTP/1.1 404 Not Found');

        exit(Skin::getContentFile(SERVER_ROOT.'Applications'.DIRECTORY_SEPARATOR.$this->app()->name().DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'redirect'.DIRECTORY_SEPARATOR.'404.php'));
    }

    /**
     * To redirect maintenance
     */
    public function redirectMaintenance(){
        $this->addHeader('HTTP/1.1 503 Service Temporarily Unavailable');

        exit(Skin::getContentFile(SERVER_ROOT.'Applications'.DIRECTORY_SEPARATOR.$this->app()->name().DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'redirect'.DIRECTORY_SEPARATOR.'maintenance.php'));
    }

    /**
     * To send response
     */
    public function send(){
        exit($this->skin()->getGeneratedSkin());
    }

    /**
     * To send json
     *
     * @param array $array
     */
    public function sendJson(array $array){
        $this->addHeader("Content-Type: application/json");
        exit(json_encode($array));
    }

    /**
     * Getter $_skin
     *
     * @return Skin $_skin
     */
    public function skin(){
        return $this->_skin;
    }

    /**
     * Setter $_skin
     *
     * @param Skin $skin
     */
    public function setSkin(Skin $skin){
        $this->_skin = $skin;
    }

    /**
     * Overload setcookie() : the last argument is by default at true.
     *
     * @param string $name
     * @param string $value
     * @param int $expire
     * @param null $path
     * @param null $domain
     * @param bool $secure
     * @param bool $httpOnly
     */
    public function setCookie($name, $value = '', $expire = 0, $path = null, $domain = null, $secure = false, $httpOnly = true){
        setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
    }
}