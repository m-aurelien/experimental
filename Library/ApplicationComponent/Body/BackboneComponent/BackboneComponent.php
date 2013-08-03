<?php
/**
 * Created by Aurelien
 * Date: 30/06/13
 * Time: 22:40
 */

namespace Library\ApplicationComponent\Body\BackboneComponent;

use Library\ApplicationComponent\Body\Backbone;

abstract class BackboneComponent{
    private $backbone;

    public function __construct(Backbone $backbone){
        $this->backbone = $backbone;
    }

    public function backbone(){
        return $this->backbone;
    }

    public function appName(){
        return $this->backbone->appName();
    }

    public function httpRequest(){
        return $this->backbone->httpRequest();
    }

    public function httpResponse(){
        return $this->backbone->httpResponse();
    }

    public function config(){
        return $this->backbone->config();
    }

    public function logger(){
        return $this->backbone->logger();
    }

    public function cache(){
        return $this->backbone->cache();
    }

    public function user(){
        return $this->backbone->user();
    }

    public function i18n(){
        return $this->backbone->i18n();
    }

    public function pdo(){
        return $this->backbone->pdo();
    }
}