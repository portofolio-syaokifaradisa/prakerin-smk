<?php
namespace App\Helpers;

class FormatHelper{
    public static function toIndonesianDateFormat($date){
        if(count(explode(' ', $date)) > 1){
            $date = explode(' ', $date)[0];
        }

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $dates = explode('-', $date);
        if(strlen($dates[0]) == 4){
            return $dates[2]. ' ' . $months[(int) $dates[1]] . ' ' . $dates[0];
        }else{
            return $dates[0]. ' ' . $months[(int) $dates[1]] . ' ' . $dates[2];
        }
    }

    public static function toIndonesianCurrencyFormat($value){
        return number_format($value,0,',','.');
    }
}
?>