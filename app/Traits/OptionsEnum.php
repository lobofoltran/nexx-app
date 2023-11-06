<?php

namespace App\Traits;

trait OptionsEnum
{
    public static function options(bool $select = false)
    {
        $data = [];
        
        foreach (self::cases() as $item) {
            if ($select) {
                $data[$item->value] = $item->label();
            } else {
                $data[] = $item->value;
            }
        }

        return $data;
    }
}