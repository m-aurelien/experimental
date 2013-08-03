<?php
/**
 * Created by Aurelien
 * Date: 04/07/13
 * Time: 14:39
 */

namespace Library\Form\FormBuilder;


use Library\Form\Form;

abstract class FormBuilder
{
    private $form;

    public function __construct()
    {
        $this->setForm(new Form());
    }

    abstract public function build();

    public function setForm(Form $form)
    {
        $this->form = $form;
    }

    public function form()
    {
        return $this->form;
    }
}