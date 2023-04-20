<?php

namespace App\Helper;

use Illuminate\Support\Facades\DB;

class SaveData
{

    public static function usermeta($data)
    {
        DB::table('usermeta')->insert($data);
    }
}
