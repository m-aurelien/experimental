<?php
/**
 * Created by Aurelien
 * Date: 28/06/13
 * Time: 15:16
 */

namespace Library;

/**
 * Initialized in the index.php, it will automatically load the classes used
 *
 * @package Library
 * @author Aurelien Mecheri
 */
class Loader {

    /**
     * @staticvar null $_instance
     */
    private static $_instance = null;

    /**
     * Initialise le loader
     *
     * Instanciation de la classe Loader
     */
    public static function init(){
        if (self::$_instance === null) {
            self::$_instance = new loader();
        }
    }

    /**
     * Add load_class function in the spl_auto_register
     */
    public function __construct()
    {
        spl_autoload_register(array($this,'load_class'));
    }

    /**
     * Load the files containing the classes used
     *
     * @param string $class
     */
    public function load_class($class)
    {
        require_once SERVER_ROOT.str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    }

    /**
     * Returns true if the class passed in parameter exists
     *
     * @static
     * @param string $class
     * @return bool
     */
    public static function class_exist($class){
        return file_exists(SERVER_ROOT.str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php');
    }

}