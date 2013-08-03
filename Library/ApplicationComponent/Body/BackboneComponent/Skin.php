<?php
/**
 * Created by Aurelien
 * Date: 30/06/13
 * Time: 23:36
 */

namespace Library\ApplicationComponent\Body\BackboneComponent;

use Library\ApplicationComponent\Body\Backbone;
use Library\ApplicationComponent\Body\BackboneComponent\BackboneComponent;
use Library\ApplicationComponent\Body\BackboneComponent\SkinComponent\MinifyJS;
use Library\ApplicationComponent\Body\BackboneComponent\SkinComponent\MinifyCSS;
use Library\ApplicationComponent\Body\BackboneComponent\SkinComponent\Template;


class Skin extends BackboneComponent{
    private $contentFile;
    private $vars = array();
    private $layout = true;
    private $js;
    private $css;
    private $template;

    public function __construct(Backbone $backbone)
    {
        parent::__construct($backbone);

        $this->js   = new MinifyJS($this);
        $this->css  = new MinifyCSS($this);
        $this->template = new Template($this);
    }


    public function addTitle($value){
        $this->addVar('title', $value);
    }
    public function addVar($var, $value){
        if (!is_string($var) || is_numeric($var) || empty($var)){
            throw new \InvalidArgumentException('Le nom de la variable doit être une chaine de caractère non nulle');
        }
        $this->vars[$var] = $value;
    }

    public function disableLayout(){
        $this->layout = false;
    }

    public function getGeneratedSkin(){
        if (!file_exists($this->contentFile)){
            throw new \RuntimeException('La vue spécifiée n\'existe pas ('.$this->contentFile.')');
        }

        if(!$this->cache()->is('Application') || ($this->cache()->is('Application') && !$this->cache()->get('Application')->isCache())){
            foreach ($this->vars as $key => $val) {
                $this->template->assign($key, $val);
            }

            extract($this->vars);

            ob_start();
                require $this->contentFile;
            $content = $this->template->interpret(ob_get_clean());

            if($this->layout){
                ob_start();
                    require SERVER_ROOT.'Applications/'.$this->backbone()->app()->name().'/Templates/layout.php';
                $generatedSkin = ob_get_clean();
            }else{
                $generatedSkin = $content;
            }

            if($this->cache()->is('Application') && !$this->cache()->get('Application')->isCache()){
                $this->cache()->get('Application')->addVar('generatedSkin', $generatedSkin);
                $this->cache()->save('Application');
            }

            return $generatedSkin;
        }else{
            return $this->cache()->get('Application')->get('generatedSkin');
        }
    }

    public function setContentFile($contentFile){
        if (!is_string($contentFile) || empty($contentFile)){
            throw new \InvalidArgumentException('La vue spécifiée est invalide');
        }
        $this->contentFile = $contentFile;
    }

    public function js(){
        return $this->js;
    }

    public function css(){
        return $this->css;
    }

    public static function getContentFile($contentFile){
        ob_start();
        require $contentFile;
        return ob_get_clean();
    }
}