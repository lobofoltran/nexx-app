<?php

namespace App\Traits;

trait OptionsEnum
{
    public static function options()
    {
        $data = [];
        
        foreach (self::cases() as $item) {
            $data[] = $item->value;
        }

        return $data;
    }
}