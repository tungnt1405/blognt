<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Log;

class Owner extends Model
{
    use HasFactory;

    const CREATE_AT = 'create_at';
    const UPDATED_AT = 'updated_at';

    protected $table = 'dtb_owner';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'avatar',
        'name',
        'introduce',
        // 'gmail_url',
        'fb_url',
        // 'twitter_url',
        'linkin_url',
        // 'zalo_url',
        'github_url',
    ];

    /**
     * Get the owner_info associated with the Owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ownerInfo(): HasOne
    {
        return $this->hasOne(OwnerInfo::class, 'owner_id', 'id');
    }
}
