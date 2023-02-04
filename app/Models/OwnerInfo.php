<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OwnerInfo extends Model
{
    use HasFactory;
    const CREATE_AT = 'create_at';
    const UPDATED_AT = 'updated_at';

    protected $table = 'dtb_owner_info';
    protected $primaryKey = 'id';
    protected $fillable = [
        'owner_id',
        'description',
        'make_project',
        'experience',
        'career_goals',
    ];

    /**
     * Get the owner that owns the OwnerInfo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class)->withDefault();
    }
}
