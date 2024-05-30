<?php

namespace App\Actions\Acronym;

class AcronumLastName
{
    public function Acronym(string $lastName): string|bool
    {
        $explode = explode(' ', $lastName);
        if (key_exists(0,$explode) && ($explode[0] <> '')){
            $return = $explode[0] . ' ';
        } else{
            return false;
        }

        if (key_exists(1,$explode)){
            $return .= mb_substr($explode[1], 0, 1). '.';
        }

        if (key_exists(2,$explode)){
            $return .= mb_substr($explode[2], 0, 1) . '.';
        }

        return $return;
    }
}
