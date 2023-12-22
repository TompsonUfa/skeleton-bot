<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperTgGroup
 */
class TgGroup extends Model
{
    use HasFactory;


    static public function findByTid($tid)
    {
        return self::query()
            ->where('tid', $tid)
            ->first();
    }
}
