<?php
/**
 * Created by Aurelien
 * Date: 04/07/13
 * Time: 14:40
 */

namespace Applications\OneTry\Services\FormBuilder;


use Library\Form\Field\PasswordField;
use Library\Form\Field\StringField;
use Library\Form\Field\SubmitField;
use Library\Form\FormBuilder\FormBuilder;
use Library\Form\Validator\MaxLengthValidator;
use Library\Form\Validator\NotNullValidator;

class ExempleFormBuilder extends FormBuilder{
    public function build(){
        $this->form()->setMethod('POST');
        $this->form()->setAction('#');

        $this->form()->add(array(new StringField(array('label' => 'Login',
                                                       'name' => 'login',
                                                       'maxLength' => 20,
                                                       'validators' => array(new MaxLengthValidator('Le texte spécifié est trop long (20 caractères maximum)', 20),
                                                                             new NotNullValidator('Merci de remplir le champ')))),
                                 new PasswordField(array('label' => 'Password',
                                                         'name' => 'password',
                                                         'maxLength' => 20,
                                                         'validators' => array(new MaxLengthValidator('Le texte spécifié est trop long (100 caractères maximum)', 100),
                                                                               new NotNullValidator('Merci de remplir le champ')))),
                                 new SubmitField(array('label' => 'Submit',
                                                       'name' => 'submit',
                                                       'classes' => 'btn'))));
    }
}