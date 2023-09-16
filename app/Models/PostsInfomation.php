<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostsInfomation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'dtb_posts_infomation';
    protected $primaryKey = 'id';
    protected $fillable = [
        'status',
        'public_date',
        'meta_content'
    ];


    /**
     * Get the posts that owns the PostsInfomation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function posts(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
