<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Aurelien
 * Date: 25/07/13
 * Time: 21:17
 * To change this template use File | Settings | File Templates.
 */

namespace Library\WebService;

/**
 * RestClient
 *
 * @package Library\WebService
 * @author Aurelien Mecheri
 */
class RestClient{
    /**
     * @access private
     * @var string $_url
     */
    private $_url;

    /**
     * Set $_url
     *
     * @param $url
     */
    public function __construct($url){
        $this->setUrl($url);
    }

    /**
     * Setter $_url
     *
     * @param string $url
     */
    public function setUrl($url){
        $this->_url = $url;
    }

    /**
     * Getter $_url
     *
     * @return string $_url
     */
    public function url(){
        return $this->_url;
    }

    /**
     * Request with GET method
     *
     * @param array $getParams
     * @return array|bool
     */
    public function get($getParams = array()){
        return $this->_execute($this->_makeUrl($getParams), $this->_createContext('GET'));
    }

    /**
     * Request with POST method
     *
     * @param array $postParams
     * @param array $getParams
     * @return array|bool
     */
    public function post($postParams=array(), $getParams = array()){
        return $this->_execute($this->_makeUrl($getParams), $this->_createContext('POST', $postParams));
    }

    /**
     * Request with PUT method
     *
     * @param array $putParams
     * @param array $getParams
     * @return array|bool
     */
    public function put($putParams = null, $getParams = array()){
        return $this->_execute($this->_makeUrl($getParams), $this->_createContext('PUT', $putParams));
    }

    /**
     * Request with DELETE method
     *
     * @param array $deleteParams
     * @param array $getParams
     * @return array|bool
     */
    public function delete($deleteParams = null, $getParams = array()){
        return $this->_execute($this->_makeUrl($getParams), $this->_createContext('DELETE', $deleteParams));
    }

    /**
     * Create context
     *
     * @param $method
     * @param array $params
     * @return resource
     */
    private function _createContext($method, $params = null){
        $opts = array('http'=>array('method'=>$method, 'header'=>'Content-type: application/x-www-form-urlencoded'));
        if ($params !== null){
            if (is_array($params)){
                $params = http_build_query($params);
            }
            $opts['http']['content'] = $params;
        }
        return stream_context_create($opts);
    }

    /**
     * Make url with GET params
     *
     * @param array $params
     * @return string
     */
    private function _makeUrl($params){
        return $this->_url.(strpos($this->_url, '?') ? '' : '?').http_build_query($params);
    }

    /**
     * Execute request
     *
     * @param string $url
     * @param resource $context
     * @return array|bool
     */
    private function _execute($url, $context){
        if (($stream = fopen($url, 'r', false, $context)) !== false){
            $header = stream_get_meta_data($stream);
            $content = stream_get_contents($stream);
            fclose($stream);
            return array('header'=>$header, 'content'=>$content);
        }else{
            return false;
        }
    }
}