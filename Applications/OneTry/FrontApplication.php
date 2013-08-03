<?php
/**
 * Created by Aurelien
 * Date: 30/06/13
 * Time: 23:52
 */

namespace Applications\OneTry;

use Library\Application;
use Library\Helper\Filter;

class FrontApplication extends Application{
    public function __construct(){
        $this->setName('OneTry');

        parent::__construct();

        $this->i18n()->setLangDefault('en');
    }

    public function run(){
        if(Filter::bool($this->config()->get('maintenance'))) $this->httpResponse->redirectMaintenance();
        if(Filter::bool($this->config()->get('cache'))) $this->cache()->enable();

        $controller = $this->controller();
        $controller->execute();

        $controller->skin()->css()->prependSource('bootstrap.min');
        $controller->skin()->css()->appendSource('bootstrap-responsive.min');
        $controller->skin()->js()->prependSource('bootstrap.min');

        $this->httpResponse()->setSkin($controller->skin());
        $this->httpResponse()->send();
    }
}