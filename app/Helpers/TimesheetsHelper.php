<?php
//app/Helpers/TimesheetsHelper
namespace App\Helpers;

class TimesheetsHelper
{
    public static function calculateTime($hours, $minutes)
    {
        $hours = $hours + floor($minutes / 60);
        $minutes = $minutes >= 60 ? $minutes % 60 : $minutes;
        $minutes = $minutes < 10 ? "0" . $minutes : $minutes;

        $hours = str_pad($hours, 2, '0', STR_PAD_LEFT);
        $minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);
    
        return "{$hours}:{$minutes}";
    }

    public static function projectByName($projects, $name)
    {
        $index = 0;
        $project = null;

        while ($index < count($projects) && $project == null) {
            if (!empty($projects[$index][0])) {
                if ($projects[$index][0] === $name) {
                    $project = $projects[$index];
                }
            }

            $index++;
        }

        return $project;
    }
}
