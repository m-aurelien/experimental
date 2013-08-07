<?php
/**
 * Created by Aurelien
 * Date: 01/07/13
 * Time: 21:53
 */

namespace Applications\OneTry\Controllers;


use Applications\OneTry\I18n\I18n;
use Applications\OneTry\Models\ORM\eOther;
use Applications\OneTry\Services\FormBuilder\ExempleFormBuilder;
use Library\ApplicationComponent\Body\Backbone;
use Library\ApplicationComponent\Database\OrmGen;
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

        //$gen = new OrmGen($this->app());
        //$gen->generate();
/*
        $e = eOther::retrieveByPk(1, 2);
        $e->setOther('coolll');
        $e->update();

        $e = new eOther();
        $e->setId(3);
        $e->setUser_id(2);
        $e->setOther('other ?');
        $e->insert();

        $e = eOther::retrieveByPk(3, 2);
        $e->delete();
*/
        /*
        $stmt = $this->pdo()->mysql()->prepare('SELECT * FROM other');
        $stmt->execute();
        $result = $stmt->fetchAllObjectOfClass("eOther");
        var_dump($result);
        */

        //var_dump(eOther::doSelect('SELECT * FROM other'));

        $form = new ExempleFormBuilder();
        $form->build();
        if($form->form()->isPostAndValid()){
            var_dump('valid !');
        }
        echo $form->form();

    }
}