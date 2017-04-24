<?php

namespace App\Validator;

final class CoreValidator
{
    const GREATER_EQUAL = 'App\Validator\CoreValidator::greaterEqual';
    const GREATER = 'App\Validator\CoreValidator::greater';
    const LESS_EQUAL = 'App\Validator\CoreValidator::lessEqual';
    const LESS = 'App\Validator\CoreValidator::less';

    public static function greaterEqual(\Nette\Forms\IControl $control, string $controlName)
    {
        return $control->getValue() >= $control->getForm()[$controlName]->getValue();
    }

    public static function greater(\Nette\Forms\IControl $control, string $controlName)
    {
        return $control->getValue() > $control->getForm()[$controlName]->getValue();
    }

    public static function lessEqual(\Nette\Forms\IControl $control, string $controlName)
    {
        return $control->getValue() <= $control->getForm()[$controlName]->getValue();
    }

    public static function less(\Nette\Forms\IControl $control, string $controlName)
    {
        return $control->getValue() < $control->getForm()[$controlName]->getValue();
    }
}
