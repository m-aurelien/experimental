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
        parent::__construct();

        $this->i18n()->setLangDefault('en');
    }

    public function run(){
        if(Filter::bool($this->config()->get('maintenance'))) $this->httpResponse()->redirectMaintenance();
        if(Filter::bool($this->config()->get('cache'))) $this->cache()->enable();

        $controller = $this->controller();
        $controller->execute();

        $controller->skin()->js()->prependSource('jquery.min');
        $controller->skin()->js()->appendSource('bootstrap.min');

        $controller->skin()->css()->prependSource('bootstrap.min');

        $this->stats()->GlobalVisit();
        $this->stats()->DailyVisit();

        $this->httpResponse()->setSkin($controller->skin());
        $this->httpResponse()->send();
    }
}