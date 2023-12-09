<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    use Translatable;

    protected $with = ['translations'];
    protected $translatedAttributes = ['name'];
    protected $fillable = ['is_active', 'photo'];
    protected $hidden = ['translations'];
    protected $casts = ['is_active' => 'boolean'];

    public function getActive()
    {
        return $this->is_active == 0 ? __('admin/category.Disable')
            : __('admin/category.Enable');
    }

    public function getPhotoAttribute($photoName)
    {
        return $photoName !== null ?
            asset('assets/images/brands/'.$photoName) : "";
    }
}
