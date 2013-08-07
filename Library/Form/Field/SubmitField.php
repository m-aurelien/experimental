<?php
/**
 * Created by Aurelien
 * Date: 04/07/13
 * Time: 14:31
 */

namespace Library\Form\Field;

/**
 * Class SubmitField
 * @package Library\Form\Field
 * @author Aurelien Mecheri
 */
class SubmitField extends Field {
    /**
     * Builder
     *
     * @return string
     */
    public function buildWidget(){
        $widget = '';

        $widget .= '<input type="submit"';
        if($this->name()) $widget .= ' name="'.$this->name().'"';
        if($this->classes()) $widget .= ' class="'.$this->classes().'"';
        if($this->value()) $widget .= ' value="'.$this->label().'"';
        $widget .= ' />';

        return $widget;
    }
}