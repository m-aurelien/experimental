<?php
/**
 * Created by Aurelien
 * Date: 30/06/13
 * Time: 23:13
 */

namespace Library\ApplicationComponent\Body;

use Library\ApplicationComponent\ApplicationComponent;
use Library\ApplicationComponent\Body\BackboneComponent\Skin;
use Library\ApplicationComponent\Cache\CacheDriver;
use Library\Application;

abstract class Backbone extends ApplicationComponent{
    private $controller = '';
    private $action = '';
    private $view = '';
    private $skin = null;
    private $model = null;

    public function __construct(Application $app, $controller, $action, $cacheDuration){
        parent::__construct($app);

        $this->skin = new Skin($this);

        // On instancie le model.
        $modelClass = 'Applications\\'.APP_NAME.'\\Models\\'.$controller.'Model';
        $this->model = new $modelClass($this);

        $this->setController($controller);
        $this->setAction($action);
        $this->setView($action);

        if($cacheDuration){
            $cacheDriver = new CacheDriver('Application', $this->controller.'-'.$this->action, $cacheDuration);
            $this->cache()->addDriver('Application', $cacheDriver);
        }
    }

    public function execute(){
        $method = ucfirst($this->action).'Action';
        if (!is_callable(array($this, $method))){
            throw new \RuntimeException('L\'action "'.$this->action.'" n\'est pas définie sur ce controller');
        }

        if(!$this->cache()->load('Application')){
            $this->$method();
        }
    }

    public function setController($controller){
        if (!is_string($controller) || empty($controller)){
            throw new \InvalidArgumentException('Le controller doit être une chaine de caractères valide');
        }
        $this->controller = $controller;
    }

    public function setAction($action){
        if (!is_string($action) || empty($action)){
            throw new \InvalidArgumentException('L\'action doit être une chaine de caractères valide');
        }
        $this->action = $action;
    }

    public function setView($view){
        if (!is_string($view) || empty($view)){
            throw new \InvalidArgumentException('La vue doit être une chaine de caractères valide');
        }
        $this->view = $view;
        $this->skin->setContentFile(SERVER_ROOT.'Applications'.DIRECTORY_SEPARATOR.APP_NAME.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.$this->controller.DIRECTORY_SEPARATOR.$this->view.'.php');
    }

    public function controllerName(){
        return $this->controller;
    }

    public function actionName(){
        return $this->action;
    }

    public function skin(){
        return $this->skin;
    }

    public function model(){
        return $this->model;
    }
}