<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperParam
 */
class Param extends Model
{
    use HasFactory;

    static function get($key, $default = null)
    {
        $d = self::query()
            ->where('key', $key)
            ->first();
        if (empty($d)) {
            return $default;
        }
        return $d->value;
    }

    static function set($key, $value)
    {
        $d = self::query()
            ->where('key', $key)
            ->first();
        if (empty($d)) {
            $d = new self();
            $d->key = $key;
        }
        $d->value = $value;
        $d->save();
        return $d->value;
    }

    static function remove($key)
    {
        $d = self::query()
            ->where('key', $key)
            ->first();
        if (!empty($d)) {
            $d->delete();
        }
    }
}
