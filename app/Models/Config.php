<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'dtb_config';
    public $timestamps = false;

    protected $primaryKey = 'uuid';
    protected $fillable = ['website_name', 'email_admin', 'maintain'];
}
