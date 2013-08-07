<?php
/**
 * Created by Aurelien
 * Date: 05/07/13
 * Time: 21:28
 */

namespace Library\ApplicationComponent\I18n;


use Library\ApplicationComponent\ApplicationComponent;

class I18nManager extends ApplicationComponent{

    private $_lang_user = null;
    private $_lang_default = null;

    public function __construct(){
        $langue = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $this->setLangUser(strtolower(substr(rtrim($langue[0]),0,2)));
    }

    /**
     * Détermine la classe qui doit exécuter la fonction en fonction de la langue
     * Langue définie par GCT_LANG__USER ou GCT_LANG__DEFAULT
     * @param string $funcName
     * @param array $params Liste ordonnée de paramètres (9 max) Array([] => param)
     * @param string $lang
     * @return string|NULL
     */
    public function translate($called, array $params = array()){
        $msg = call_user_func('\Applications\OneTry\I18n\I18n::'.$called, $this);
        return vsprintf($msg, $params);
    }

    /**
     * Setter $_lang_default
     *
     * @param string $lang_default
     */
    public function setLangDefault($lang_default){
        $this->_lang_default = $lang_default;
    }

    /**
     * Getter $_lang_default
     *
     * @return string $_lang_default
     */
    public function langDefault(){
        return $this->_lang_default;
    }

    /**
     * Setter $_lang_user
     *
     * @param string $lang_user
     */
    public function setLangUser($lang_user){
        $this->_lang_user = $lang_user;
    }

    /**
     * Getter $_lang_user
     *
     * @return string $_lang_user
     */
    public function langUser(){
        return $this->_lang_user;
    }



}