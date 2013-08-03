<?php
/**
 * Created by Aurelien
 * Date: 01/07/13
 * Time: 21:53
 */

namespace Applications\OneTry\Controllers;


use Applications\OneTry\I18n\I18n;
use Applications\OneTry\Services\FormBuilder\ExempleFormBuilder;
use Library\ApplicationComponent\Body\Backbone;
use Library\ApplicationComponent\Database\DaoGen;
use Library\Cache;
use Library\Helper\Filter;

class testController extends Backbone {

    public function indexAction(){
        $this->skin()->addTitle('Simple Titre');

        //echo $this->app()->i18n()->translate(I18n::FIRST_EXEMPLE).'<br/>';
        //echo $this->app()->i18n()->translate(I18n::SECOND_EXEMPLE).'<br/>';
        //echo $this->app()->i18n()->translate(I18n::THIRD_EXEMPLE_WITH_PARAM, array('"Ceci est un parametre"')).'<br/>';

        //$this->skin()->js()->setJSVar('RED', 'rouge');

        //$formBuilder = new ExempleFormBuilder();
        //$formBuilder->build();

        //$form = $formBuilder->form();
        //echo $form->createView();

        //var_dump(getenv('ENV'));
        //var_dump($this->config()->vars());

        //Filter::int('<<<<zare....'));

        //$client = new \Library\WebService\RestClient('http://localhost:8080/experimental/onetry/ws/HelloServices/sayHello');
        //echo json_decode($client->post(array('name' => 'Aurel'))['content']);

        /*
        $this->cache()->setFile('exemple');
        if(!$this->cache()->load()){
            echo 'je cache';
            $example = array('tr' => 'test cache');

            $this->cache()->addVar('test', $example);
            $this->cache()->addVar('test2', 'coucou');
            $this->cache()->save(3);
        }
        var_dump($this->cache()->getVar('test'));
        */

        //exit;

        $gen = new DaoGen($this->app());
        $gen->generate();
    }
}