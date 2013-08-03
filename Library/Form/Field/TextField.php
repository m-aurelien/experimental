<?php
/**
 * Created by Aurelien
 * Date: 04/07/13
 * Time: 14:32
 */

namespace Library\Form\Field;


class TextField extends Field
{
    private $cols;
    private $rows;

    public function buildWidget()
    {
        $widget = '';

        if ($this->hasErrorMessage())
        {
            $widget .= $this->errorMessage().'<br />';
        }

        $widget .= '<label>'.$this->label().'</label><textarea name="'.$this->name().'"';

        if (!empty($this->cols))
        {
            $widget .= ' cols="'.$this->cols.'"';
        }

        if (!empty($this->rows))
        {
            $widget .= ' rows="'.$this->rows.'"';
        }

        $widget .= '>';

        if ($this->hasValue())
        {
            $widget .= htmlspecialchars($this->value());
        }

        return $widget.'</textarea>';
    }

    public function setCols($cols)
    {
        $cols = (int) $cols;

        if ($cols > 0)
        {
            $this->cols = $cols;
        }
    }

    public function setRows($rows)
    {
        $rows = (int) $rows;

        if ($rows > 0)
        {
            $this->rows = $rows;
        }
    }
}