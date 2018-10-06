<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

class General
{
    public static function brief_num($n, $precision = 2)
    {
        if ($n < 1000) {
            // Anything less than a million
            $n_format = number_format($n);
        } else if($n < 1000000) {
            $n_format = number_format($n / 1000, $precision) . 'K';            
        } else if ($n < 1000000000) {
            $n_format = number_format($n / 1000000, $precision) . 'M';
        } else {
            $n_format = number_format($n / 1000000000, $precision) . 'B';
        }

        return $n_format;
    }
}

?>
