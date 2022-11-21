<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $table = 'dtb_owner';

    protected $fillable = [
        'thumbnail',
        'name_owner',
        'description',
        'link_1',
        'link_2',
        'link_3',
        'link_4',
        'link_5',
        'link_6',
        'create_at',
        'update_at'
    ];


    // public function scopeGetById($query)
    // {
    //     return $query->with([]);
    // }
}