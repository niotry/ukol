<?php

namespace App\components;

use Nette\Forms\IControl;
use Nette\Utils\DateTime;

class FormValidator
{
    const DATE = __CLASS__ . '::date';

    public static function date(IControl $control)
    {
        $value = $control->getValue();

        return $value === '' || DateTime::createFromFormat('d.m.Y', $value);
    }
}
