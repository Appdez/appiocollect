<?php

namespace App\Http\Traits;
/**
 *
 */
trait ArrayToFormattedString
{

    public function convertToString( $array = [])
    {
        $result = "";
        foreach ($array as $value) {
           $result .= $value. "; ";
        }
        return $result;
    }
}

