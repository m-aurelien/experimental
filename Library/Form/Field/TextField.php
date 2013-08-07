<?php
/**
 * Created by Aurelien
 * Date: 04/07/13
 * Time: 14:32
 */

namespace Library\Form\Field;

/**
 * Class TextField
 * @package Library\Form\Field
 * @author Aurelien Mecheri
 */
class TextField extends Field{
    /**
     * @access private
     * @var
     */
    private $_cols;
    /**
     * @access private
     * @var
     */
    private $_rows;

    /**
     * Builder
     *
     * @return string
     */
    public function buildWidget(){
        $widget = '';

        if($this->label()) $widget  = '<label>'.$this->label().'</label>';

        $widget .= '<textarea name="'.$this->name().'"';
        if (!empty($this->_cols)) $widget .= ' cols="'.$this->_cols.'"';
        if (!empty($this->_rows)) $widget .= ' rows="'.$this->_rows.'"';
        $widget .= '>';
        if ($this->hasValue()) $widget .= htmlspecialchars($this->value());
        $widget .= '</textarea>';

        if ($this->hasErrorMessage()) $widget .= '<p>'.$this->errorMessage().'</p>';

        return $widget;
    }

    /**
     * Setter $_cols
     *
     * @param int $cols
     */
    public function setCols($cols){
        $cols = (int) $cols;

        if ($cols > 0){
            $this->_cols = $cols;
        }
    }

    /**
     * Setter $_rows
     *
     * @param int $rows
     */
    public function setRows($rows){
        $rows = (int) $rows;

        if ($rows > 0){
            $this->_rows = $rows;
        }
    }
}