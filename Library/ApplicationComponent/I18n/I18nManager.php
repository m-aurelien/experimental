<?php
/**
 * Created by Aurelien
 * Date: 05/07/13
 * Time: 21:28
 */

namespace Library\ApplicationComponent\I18n;


use Library\ApplicationComponent\ApplicationComponent;

class I18nManager extends ApplicationComponent{

    private $lang_user = null;
    private $lang_default = null;

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
     public function translate($called, array $params = array()) {
        $msg = call_user_func('\Applications\OneTry\I18n\I18n::'.$called, $this);
        return vsprintf($msg, $params);

    }

    /**
     * @param mixed $lang_default
     */
    public function setLangDefault($lang_default)
    {
        $this->lang_default = $lang_default;
    }

    /**
     * @return mixed
     */
    public function langDefault()
    {
        return $this->lang_default;
    }

    /**
     * @param mixed $lang_user
     */
    public function setLangUser($lang_user)
    {
        $this->lang_user = $lang_user;
    }

    /**
     * @return mixed
     */
    public function langUser()
    {
        return $this->lang_user;
    }



}