<?php
/**
 * Created by Aurelien
 * Date: 01/07/13
 * Time: 23:24
 */

namespace Library\ApplicationComponent\Config;


use Library\Application;
use Library\ApplicationComponent\ApplicationComponent;

/**
 * Config
 *
 * @package Library\ApplicationComponent\Config
 * @author Aurelien Mecheri
 */
class Config extends ApplicationComponent{
    /**
     * @access private
     * @var \DOMDocument
     */
    private $_xml;
    /**
     * @access private
     * @var array
     */
    private $_vars = array();

    /**
     * Set $_xml & $_vars
     *
     * @param Application $app
     */
    public function __construct(Application $app){
        parent::__construct($app);

        $this->_xml = new \DOMDocument;
        $this->_xml->load(SERVER_ROOT.'Applications/'.APP_NAME.'/Configs/app.xml');

        foreach ($this->extendList() as $environment) {
            $this->push($environment);
        }
    }

    /**
     * Return ExtendList
     *
     * @return array
     * @throws \Exception
     */
    private function extendList(){
        $environment = ($this->_xml->getElementsByTagName(getenv('ENV'))->length == 1) ? $this->_xml->getElementsByTagName(getenv('ENV'))->item(0) : null;
        if(!is_null($environment)){
            if(!$environment->hasAttribute('extend')){
                return array($environment);
            }else{
                $extendList = array();
                array_unshift($extendList, $environment);

                while($environment->hasAttribute('extend')){
                    $environment = ($this->_xml->getElementsByTagName($environment->getAttribute('extend'))->length == 1) ? $this->_xml->getElementsByTagName($environment->getAttribute('extend'))->item(0) : null;
                    if(is_null($environment)){
                        throw new \Exception('XMLConfig extend not found');
                    }else{
                        array_unshift($extendList, $environment);
                    }
                }
                return $extendList;
            }
        }else{
            throw new \Exception('XMLConfig not found');
        }
    }

    /**
     * Push vars in $_vars
     *
     * @param $environment
     */
    private function push($environment){
        $defines = $environment->getElementsByTagName('define');
        foreach ($defines as $define) {

            if($define->getAttribute('type') == 'array'){
                if(!array_key_exists($define->getAttribute('var'), $this->_vars)){
                    $this->_vars[$define->getAttribute('var')] = array();
                }
                if($define->hasAttribute('key')){
                    $this->_vars[$define->getAttribute('var')][$define->getAttribute('key')] = $define->getAttribute('value');
                }else{
                    $this->_vars[$define->getAttribute('var')][] = $define->getAttribute('value');
                }
            }else{
                $this->_vars[$define->getAttribute('var')] = $define->getAttribute('value');
            }
        }
    }

    /**
     * Getter $_vars by key
     *
     * @param string $key
     * @return string $_vars[$key]
     */
    public function get($key)
    {
        if (isset($this->_vars[$key]))
        {
            return $this->_vars[$key];
        }

        return null;
    }

    /**
     * Getter $_vars
     *
     * @return array $_vars
     */
    public function vars(){
        return $this->_vars;
    }
}