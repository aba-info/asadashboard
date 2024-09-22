<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class DatabaseHelper
{
    public static function pluckFromDatabase($table, $valueColumn, $keyColumn = 'id')
    {
        $data = DB::table($table)->pluck($valueColumn, $keyColumn)->all();
        return $data;
    }
}
