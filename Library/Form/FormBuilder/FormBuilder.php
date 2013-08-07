<?php
/**
 * Created by Aurelien
 * Date: 04/07/13
 * Time: 14:39
 */

namespace Library\Form\FormBuilder;


use Library\Form\Form;

/**
 * FormBuilder
 *
 * @package Library\Form\FormBuilder
 * @author Aurelien Mecheri
 * @abstract
 */
abstract class FormBuilder{
    /**
     * @access private
     * @var Form $_form
     */
    private $_form;

    /**
     * Construct : Instanciates Form in $_form
     * @param null $method
     * @param null $action
     * @param array $attributes
     */
    public function __construct(){
        $this->setForm(new Form());
    }

    /**
     * Builder
     *
     * @abstract
     */
    abstract public function build();

    /**
     * Setter $_form
     *
     * @param Form $form
     */
    public function setForm(Form $form){
        $this->_form = $form;
    }

    /*
     * Getter $_form
     *
     * return Form $form
     */
    public function form(){
        return $this->_form;
    }
}