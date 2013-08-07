<?php
/**
 * Created by Aurelien
 * Date: 01/07/13
 * Time: 23:18
 */

namespace Library\ApplicationComponent\Auth;

use Library\Application;
use Library\ApplicationComponent\ApplicationComponent;
use Library\Helper\Token;

class User extends ApplicationComponent{
    private $_authId = null;
    private $_flash = null;
    private $_attributes = array();
    private $_token;

    public function __construct(Application $app){
        parent::__construct($app);

        $this->_token = new Token();
        try{
            $values = $this->_token->values();
            $this->_authId = $values['authId'];
            $this->_flash = $values['flash'];
            $this->_attributes = $values['attributes'];
            $this->generateToken();
        }catch(\Exception $e){}
    }

    public function setAttributes(array $attributes){
        $this->_attributes = $attributes;
    }

    public function setAttribute($attr, $value){
        $this->_attributes[$attr] = $value;
        $this->generateToken();
    }

    public function attributes(){
        return $this->_attributes;
    }

    public function attribute($attr){
        return array_key_exists($attr, $this->_attributes) ? $this->_attributes[$attr] : null;
    }

    public function hasFlash(){
        return !is_null($this->_flash);
    }

    public function setFlash($value){
        $this->_flash = $value;
        $this->generateToken();
    }

    public function flash(){
        $flash = $this->_flash;
        $this->_flash = null;
        $this->generateToken();
        return $flash;
    }

    public function isAuthenticated(){
        return !is_null($this->_authId);
    }

    public function setAuthId($authId){
       $this->_authId = $authId;
       $this->generateToken();
    }

    public function authId(){
        return $this->_authId;
    }

    public function disconnect($msg){
        $this->_authId = null;
        $this->_flash = $msg;
        $this->generateToken();
    }

    public function setTokenValidityTime($time){
        $this->_token->setValidityTime($time);
    }

    private function generateToken(){
        $this->_token->setValues(array('authId' => $this->_authId, 'flash' => $this->_flash, 'attributes' => $this->_attributes));
        $this->_token->generate();
    }
}