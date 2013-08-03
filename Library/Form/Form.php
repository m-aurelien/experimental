<?php
/**
 * Created by Aurelien
 * Date: 04/07/13
 * Time: 12:00
 */

namespace Library\Form;


use Library\Form\Field\Field;

class Form {
    private $fields;

    public function add(Field $field)
    {
        $this->fields[] = $field; // On ajoute le champ passé en argument à la liste des champs.
        return $this;
    }

    public function createView()
    {
        $view = '';

        // On génère un par un les champs du formulaire.
        foreach ($this->fields as $field)
        {
            $view .= $field->buildWidget().'<br />';
        }

        return $view;
    }

    public function isValid()
    {
        // On vérifie que tous les champs sont valides.
        foreach ($this->fields as $field)
        {
            if (!$field->isValid())
            {
                return false;
            }
        }

        return true;
    }
}