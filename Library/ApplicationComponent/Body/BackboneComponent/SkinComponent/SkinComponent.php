<?php
/**
 * Created by Aurelien
 * Date: 30/06/13
 * Time: 22:40
 */

namespace Library\ApplicationComponent\Body\BackboneComponent\SkinComponent;

use Library\ApplicationComponent\Body\BackboneComponent\Skin;

abstract class SkinComponent{
    private $skin;

    public function __construct(Skin $skin){
        $this->skin = $skin;
    }

    public function skin(){
        return $this->skin;
    }

    public function appName(){
        return $this->skin->appName();
    }

    public function httpRequest(){
        return $this->skin->httpRequest();
    }

    public function httpResponse(){
        return $this->skin->httpResponse();
    }

    public function config(){
        return $this->skin->config();
    }

    public function logger(){
        return $this->skin->logger();
    }

    public function cache(){
        return $this->skin->cache();
    }

    public function user(){
        return $this->skin->user();
    }

    public function i18n(){
        return $this->skin->i18n();
    }

    public function pdo(){
        return $this->skin->pdo();
    }
}