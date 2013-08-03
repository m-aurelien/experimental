<?php
/**
 * Created by Aurelien
 * Date: 05/07/13
 * Time: 21:29
 */

namespace Library\ApplicationComponent\I18n;


use Library\Loader;

abstract class I18nData {

    const __SELF__ = __CLASS__;

    /**
     * Renvoie la valeur de la constante traduite
     *    Ex: 'fr_FR' 'en_US'
     * @param string $name
     * @param array $args
     * @return string|NULL
     */
    static function __callStatic($name, $args) {

        # on récupère la classe propriétaire de la constante (pilotClass)
        $caller  = 'Applications\OneTry\I18n\I18n';

        # langue de traduction
        if($args[0]->langUser() != null){
            $lang = $args[0]->langUser();
        }elseif($args[0]->langDefault() != null){
            $lang = $args[0]->langDefault();
        }else{
            return $name;
        }

        if(Loader::class_exist($caller . '_' . $lang)){
            $msg = constant($caller . '_' . $lang . '::' . $name);
        }else{
            $msg = null;
        }


        # si pas de traduction trouvée, récupère la traduction avec le langage par défaut
        if (($msg == null) && ($lang != $args[0]->langDefault())) {
            $msg = constant($caller . '_' . $args[0]->langDefault() . '::' . $name);
        }

        return ($msg == null) ? $name : $msg;
    }
}
?>