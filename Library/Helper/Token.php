<?php
/**
 * Created by Aurelien
 * Date: 07/08/13
 * Time: 15:08
 */

namespace Library\Helper;


use Library\Application;

class Token {
    const SECRET_KEY = "S3Cr3t_K3y";

    private $_validity_time = 600;
    private $_values;

    private $_tokenOption = null;
    private $_tokenClear;
    private $_token;

    private function _generateTokenClear(){
        $this->_tokenClear = self::SECRET_KEY.$_SERVER["SERVER_NAME"].$_SERVER['HTTP_USER_AGENT'].($this->_tokenOption) ? $this->_tokenOption : '';
    }

    private function _isValid(){
        $this->_generateTokenClear();

        $this->_token = hash('sha256', $this->_tokenClear.Application::instance()->httpRequest()->cookie("session_informations"));

        if(strcmp(Application::instance()->httpRequest()->cookie("session_token"), $this->_token) == 0){
            $info = unserialize(Application::instance()->httpRequest()->cookie("session_informations"));

            if($info['time'] + $this->_validity_time >= time() && $info['time'] <= time()){
                $this->_values = $info['values'];
            }else{
                throw new \Exception('Wrong timing');
            }
        }else{
            throw new \Exception('Token check failed');
        }
    }

    public function __construct($values = null, $time = null){
        if($values) $this->_values = $values;
        if($time) $this->_validity_time = $time;
    }

    public function setValidityTime($time){
        $this->_validity_time = $time;
    }

    public function setValues($values){
        $this->_values = $values;
    }

    public function setTokenOption($opt){
        $this->_tokenOption = $opt;
    }

    public function generate(){
        $this->_generateTokenClear();

        $info = array('time' => time(), 'values' => $this->_values);

        $this->_token = hash('sha256', $this->_tokenClear.serialize($info));

        Application::instance()->httpResponse()->setCookie("session_token", $this->_token, time()+$this->_validity_time);
        Application::instance()->httpResponse()->setCookie("session_informations", serialize($info), time()+$this->_validity_time);

        return $this->_token;
    }

    public function values(){
        $this->_isValid();

        return $this->_values;
    }
}