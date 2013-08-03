<?php
/**
 * Created by Aurelien
 * Date: 03/07/13
 * Time: 10:01
 */

namespace Library\ApplicationComponent\Body\BackboneComponent\SkinComponent;


use Library\ApplicationComponent\Body\BackboneComponent\SkinComponent\SkinComponent;
use Library\ApplicationComponent\Body\Skin;

class MinifyJS extends SkinComponent{
    private $sources = array();
    private $vars = array();

    public function uncompressedSources(){
        return $this->sources;
    }

    private function compressedSources(){
        //TODO : Compression des fichiers JS
        return $this->sources;
    }

    public function appendSource($source){
        $this->sources[] = $source;
    }

    public function prependSource($source){
        array_unshift($this->sources, $source);
    }

    public function setJSVar($varName, $value){
        $this->vars[$varName] = $value;
    }

    public function render($compressed = false){
        if($compressed){
            $render = '<script type="text/javascript" src="'.SITE_ROOT.'/js/' . $this->compressedSources() . '.js"></script>';
        }else{
            $render = '';
            foreach($this->uncompressedSources() as $source){
                $render .= '<script type="text/javascript" src="'.SITE_ROOT.'/js/'.$source.'.js"></script>';
            }
            if(!empty($this->vars)){
                $render .= '<script type="text/javascript">';
                foreach($this->vars as $key => $val){
                    $render .= 'var '.$key.' = "'.$val.'";';
                }
                $render .= '</script>';
            }
        }
        return $render;
    }
}