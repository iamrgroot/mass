<?php

namespace App\Traits;

trait FormatBytes
{
    public function formatBytes(?int $number): string
    {
        if ($number === null) {
            return '';
        }
    
        $negative = $number < 0;
        $units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    
        if ($negative) {
            $number = -$number;
        }
    
        if ($number < 1) {
            return ($negative ? '-' : '') . $number . ' B';
        }

        $exponent = min(floor(log($number) / log(1000)), count($units) - 1);
        $number = round(($number / pow(1000, $exponent)), 2);

        return ($negative ? '-' : '') . "{$number} {$units[$exponent]}";
    }
}
