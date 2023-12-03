<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Translatable;

    protected $with = ['translations'];
    protected $translatedAttributes = ['value'];
    protected $fillable = [
        'key',
        'is_translatable',
        'plain_value'
    ];
    protected $casts = ['is_translatable' => 'boolean'];

    public static function setData($setting)
    {
        foreach($setting as $key => $value) {
            self::setArray($key, $value);
        }
    }

    public static function setArray($key, $value)
    {
        if($key === 'translatable') {
            self::setTranslatableSetting($value);
        }

        if(is_array($value)) {
            $value = json_encode($value);
        }

        self::updateOrCreate(['key' => $key ], ['plain_value' => $value]);
    }

    public static function setTranslatableSetting($setting = [])
    {
        foreach($setting as $key => $value) {
            self::updateOrCreate(['key' => $key],
                ['is_translatable' => true, 'value' => $value]);
        }
    }
}
