<?php
/**
 * Created by Aurelien
 * Date: 03/07/13
 * Time: 10:01
 */

namespace Library\ApplicationComponent\Body\BackboneComponent\SkinComponent;

use Library\ApplicationComponent\Body\BackboneComponent\SkinComponent\SkinComponent;

class Template extends SkinComponent{
    private $keyVar = array();
    private $valVar = array();

    public function displayTemplate($file) {
        ob_start();
            require SERVER_ROOT.'Applications'.DIRECTORY_SEPARATOR.APP_NAME.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.$file[1].'.php';
        return ob_get_clean();
    }

    public function assign($key, $val) {
        $this->keyVar[] = "{".$key."}";
        $this->valVar[] = $val;
    }

    public function interpret($content) {
        if(ob_get_level() != 0){
            $temp = ob_get_clean();
        }

        // Ajout des templates
        $content = preg_replace_callback('/{{(.+)}}/', array($this, 'displayTemplate') , $content);

        // Affectation des variables
        $content = str_replace($this->keyVar, $this->valVar, $content);


        return (isset($temp)) ? $temp.$content : $content;
    }
}