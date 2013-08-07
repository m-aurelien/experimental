<?php
/**
 * Created by Aurelien
 * Date: 04/07/13
 * Time: 14:31
 */

namespace Library\Form\Field;

/**
 * Class StringField
 * @package Library\Form\Field
 * @author Aurelien Mecheri
 */
class StringField extends Field{
    /**
     * @access private
     * @var
     */
    private $_maxLength;

    /**
     * Builder
     *
     * @return string
     */
    public function buildWidget(){
        $widget = '';

        $widget .= '<div class="form-group">';

        if($this->label()) $widget  = '<label>'.$this->label().'</label>';

        $widget .= '<input type="text" name="'.$this->name().'"';

        $widget .= ' class="form-control ';
        if($this->classes()) $widget .= $this->classes();
        $widget .= '"';

        if ($this->hasValue()) $widget .= ' value="'.htmlspecialchars($this->value()).'"';
        if (!empty($this->_maxLength)) $widget .= ' maxlength="'.$this->_maxLength.'"';
        $widget .= ' />';

        if ($this->hasErrorMessage()) $widget .= '<p>'.$this->errorMessage().'</p>';

        $widget .= '</div>';

        return $widget;
    }

    /**
     * Setter $_maxLength
     *
     * @param int $maxLength
     * @throws \RuntimeException
     */
    public function setMaxLength($maxLength){
        $maxLength = (int) $maxLength;

        if ($maxLength > 0){
            $this->_maxLength = $maxLength;
        }else{
            throw new \RuntimeException('La longueur maximale doit être un nombre supérieur à 0');
        }
    }
}