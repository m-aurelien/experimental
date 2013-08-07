<?php
/**
 * Created by Aurelien
 * Date: 04/07/13
 * Time: 12:00
 */

namespace Library\Form;


use Library\Application;

/**
 * Form
 *
 * @package Library\Form
 * @author Aurelien Mecheri
 */
class Form {
    /**
     * Const METHOD_GET
     */
    const METHOD_GET = "GET";
    /**
     * Const METHOD_POST
     */
    const METHOD_POST = "POST";

    /**
     * @access private
     * @var string $_method
     */
    private $_method;
    /**
     * @access private
     * @var string $_action
     */
    private $_action;
    /**
     * @access private
     * @var array $_attributes
     */
    private $_attributes = array();
    /**
     * @access private
     * @var array $_fields
     */
    private $_fields = array();

    /**
     * Setter $_method
     *
     * @param string $method
     */
    public function setMethod($method){
        $this->_method = $method;
    }

    /**
     * Setter $_action
     *
     * @param string $action
     */
    public function setAction($action){
        $this->_action = $action;
    }

    /**
     * Setter $_attributes
     *
     * @param array $attributes
     */
    public function setAttributes(array $attributes){
        $this->_attributes = $attributes;
    }

    /**
     * Setter Field
     *
     * @param array $fields
     */
    public function add(array $fields){
        $this->_fields = array_merge($this->_fields, $fields);
    }

    /**
     * Create view
     *
     * @return string
     */
    public function createView(){
        $view = '<form ';
        if($this->_method) $view .= 'method="'.$this->_method.'" ';
        if($this->_action) $view .= 'action="'.$this->_action.'" ';
        foreach ($this->_attributes as $key => $value) {
            $view .= $key.'="'.$value.'"';
        }
        $view .= '>';

        foreach ($this->_fields as $field){
            $view .= $field->buildWidget();
        }

        $view .= '</form>';
        return $view;
    }

    /**
     * Check if form is submit and valid
     *
     * @return bool
     */
    public function isPostAndValid(){
        $return = true;

        if($this->_method = self::METHOD_POST){
            $values = Application::instance()->httpRequest()->posts();
        }else{
            $values = Application::instance()->httpRequest()->gets();
        }

        foreach ($this->_fields as $field) {
            if(array_key_exists($field->name(), $values)){
                $field->setValue($values[$field->name()]);

                if (!$field->isValid()){
                    $return = false;
                }
            }else{
                $return = false;
            }
        }

        return $return;
    }

    /**
     * To string to display
     * Equivalent to createView()
     *
     * @return string
     */
    function __toString(){
        return $this->createView();
    }
}