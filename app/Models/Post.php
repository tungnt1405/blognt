<?php

namespace App\Models;

use App\Models\Master\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    const CREATE_AT = 'create_at';
    const UPDATED_AT = 'updated_at';

    protected $table = 'dtb_posts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'author_id',
        'category_id',
        'title',
        'slug',
        'description',
        'content',
        'parent_id',
        'series',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Get the posts_infomation associated with the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function postsInfomation(): HasOne
    {
        return $this->hasOne(PostsInfomation::class, 'post_id', 'id');
    }

    /**
     * Get the category that owns the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
