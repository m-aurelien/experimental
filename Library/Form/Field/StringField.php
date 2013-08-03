<?php
/**
 * Created by Aurelien
 * Date: 04/07/13
 * Time: 14:31
 */

namespace Library\Form\Field;


class StringField extends Field
{
    private $maxLength;

    public function buildWidget()
    {
        $widget = '';

        if ($this->hasErrorMessage())
        {
            $widget .= $this->errorMessage().'<br />';
        }

        $widget .= '<label>'.$this->label().'</label><input type="text" name="'.$this->name().'"';

        if ($this->hasValue())
        {
            $widget .= ' value="'.htmlspecialchars($this->value()).'"';
        }

        if (!empty($this->maxLength))
        {
            $widget .= ' maxlength="'.$this->maxLength.'"';
        }

        return $widget .= ' />';
    }

    public function setMaxLength($maxLength)
    {
        $maxLength = (int) $maxLength;

        if ($maxLength > 0)
        {
            $this->maxLength = $maxLength;
        }
        else
        {
            throw new \RuntimeException('La longueur maximale doit être un nombre supérieur à 0');
        }
    }
}