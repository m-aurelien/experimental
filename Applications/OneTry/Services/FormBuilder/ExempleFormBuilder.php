<?php
/**
 * Created by Aurelien
 * Date: 04/07/13
 * Time: 14:40
 */

namespace Applications\OneTry\Services\FormBuilder;


use Library\Form\Field\StringField;
use Library\Form\Field\TextField;
use Library\Form\FormBuilder\FormBuilder;
use Library\Form\Validator\MaxLengthValidator;
use Library\Form\Validator\NotNullValidator;

class ExempleFormBuilder extends FormBuilder
{
    public function build()
    {
        $this->form()->add(new StringField(array(
            'label' => 'Champ1',
            'name' => 'champ1',
            'maxLength' => 20,
            'validators' => array(
                new MaxLengthValidator('Le texte spécifié est trop long (20 caractères maximum)', 20),
                new NotNullValidator('Merci de emplir le champ'),
            ),
        )))
            ->add(new StringField(array(
                'label' => 'Champ2',
                'name' => 'champ2',
                'maxLength' => 100,
                'validators' => array(
                    new MaxLengthValidator('Le texte spécifié est trop long (100 caractères maximum)', 100),
                    new NotNullValidator('Merci de remplir le champ'),
                ),
            )))
            ->add(new TextField(array(
                'label' => 'Champ3',
                'name' => 'champ3',
                'rows' => 8,
                'cols' => 60,
                'validators' => array(
                    new NotNullValidator('Merci de remplir le champ'),
                ),
            )));
    }
}