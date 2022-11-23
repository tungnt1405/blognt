<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Owner extends Model
{
    use HasFactory;

    protected $table = 'dtb_owner';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

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


    public function scopeGetAllOwner($query)
    {
        return $query->all();
    }

    public function createOwner($data)
    {
        try {
            return $this->create($data);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
        }
    }
}
