<?php
/**
 * Created by Aurelien
 * Date: 03/07/13
 * Time: 10:01
 */

namespace Library\ApplicationComponent\Body\BackboneComponent\SkinComponent;

use Library\ApplicationComponent\Body\BackboneComponent\SkinComponent\SkinComponent;

class MinifyCSS extends SkinComponent{
    private $sources = array();

    public function uncompressedSources(){
        return $this->sources;
    }

    private function compressedSources(){
        //TODO : Compression des fichiers CSS
        return $this->sources;
    }

    public function appendSource($source){
        $this->sources[] = $source;
    }

    public function prependSource($source){
        array_unshift($this->sources, $source);
    }

    public function render($compressed = false){
        if($compressed){
            $render = '<link rel="stylesheet" href="'.SITE_ROOT.'/css/' . $this->compressedSources() . '.css" type="text/css"/>';
        }else{
            $render = '';
            foreach($this->uncompressedSources() as $source){
                $render .= '<link rel="stylesheet" href="'.SITE_ROOT.'/css/'.$source.'.css" type="text/css"/>';
            }
        }
        return $render;
    }
}