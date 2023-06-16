<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        parent::toArray($request);

        return [
            'post_id' => $this->id,
            'post_name' => $this->title,
            'post_slug' => $this->slug,
            'creator_post' => new UserResource($this->user),
            'category_post' => new CategoriesResource($this->category),
            'post_description' => $this->description,
            'post_content' => $this->content,
            'is_serires' => $this->series ? true : false,
            'other_information' => new PostInfomationResource($this->postsInfomation),
            'post_thumb' => $this->thumbnail_posts,
            'created_at' => Carbon::parse($this->created_at)->format("Y-m-d"),
            'updated_at' => Carbon::parse($this->updated_at)->format("Y-m-d"),
        ];
    }
}
