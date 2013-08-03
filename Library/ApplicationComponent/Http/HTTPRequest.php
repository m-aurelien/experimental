<?php
/**
 * Created by Aurelien
 * Date: 30/06/13
 * Time: 22:19
 */

namespace Library\ApplicationComponent\Http;


use Library\ApplicationComponent\ApplicationComponent;

/**
 * HTTPRequest
 *
 * @package Library\ApplicationComponent\Http
 * @author Aurelien Mecheri
 */
class HTTPRequest extends ApplicationComponent{
    /**
     * Check cookie exist by key
     *
     * @param string $key
     * @return bool
     */
    public function isCookie($key){
        return isset($_COOKIE[$key]);
    }

    /**
     * Getter cookie by key
     *
     * @param string $key
     * @return mixed
     */
    public function cookie($key){
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }

    /**
     * Getter cookies
     *
     * @return mixed
     */
    public function cookies(){
        return isset($_COOKIE) ? $_COOKIE : null;
    }

    /**
     * Check GET exist by key
     *
     * @param string $key
     * @return bool
     */
    public function isGet($key){
        return isset($_GET[$key]);
    }

    /**
     * Getter GET by key
     *
     * @param string $key
     * @return mixed
     */
    public function get($key){
        return isset($_GET[$key]) ? $_GET[$key] : null;
    }

    /**
     * Getter GET
     *
     * @return mixed
     */
    public function gets(){
        return isset($_GET) ? $_GET : null;
    }

    /**
     * Check POST exist by key
     *
     * @param string $key
     * @return bool
     */
    public function isPost($key){
        return isset($_POST[$key]);
    }

    /**
     * Getter POST by key
     *
     * @param string $key
     * @return mixed
     */
    public function post($key){
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }

    /**
     * Getter POST
     *
     * @return mixed
     */
    public function posts(){
        return isset($_POST) ? $_POST : null;
    }

    /**
     * Check FILE exist by key
     *
     * @param string $key
     * @return bool
     */
    public function isFile($key){
        return isset($_FILES[$key]);
    }

    /**
     * Getter FILE by key
     *
     * @param string $key
     * @return mixed
     */
    public function file($key){
        return isset($_FILES[$key]) ? $_FILES[$key] : null;
    }

    /**
     * Getter FILE
     *
     * @return mixed
     */
    public function files(){
        return isset($_FILES) ? $_FILES : null;
    }

    /**
     * Getter method
     *
     * @return mixed
     */
    public function method(){
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Getter requestURI
     *
     * @return mixed
     */
    public function requestURI(){
        return $_SERVER['REQUEST_URI'];
    }
}