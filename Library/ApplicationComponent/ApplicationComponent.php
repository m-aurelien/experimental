<?php
/**
 * Created by Aurelien
 * Date: 30/06/13
 * Time: 22:40
 */

namespace Library\ApplicationComponent;


use Library\Application;

abstract class ApplicationComponent{
    private $app;

    public function __construct(Application $app){
        $this->app = $app;
        $app->setCurrentInstance();
    }

    public function app(){
        return $this->app;
    }

    public function httpRequest(){
        return $this->app->httpRequest();
    }

    public function httpResponse(){
        return $this->app->httpResponse();
    }

    public function config(){
        return $this->app->config();
    }

    public function logger(){
        return $this->app->logger();
    }

    public function stats(){
        return $this->app->stats();
    }

    public function cache(){
        return $this->app->cache();
    }

    public function user(){
        return $this->app->user();
    }

    public function i18n(){
        return $this->app->i18n();
    }

    public function pdo(){
        return $this->app->pdo();
    }
}