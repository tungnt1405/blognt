<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SideBarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        parent::toArray($request);
        return [
            'owner_id' => @$this->id,
            'owner_avatar' => @$this->avatar,
            'owner_name' => @$this->name,
            'owner_description' => @$this->introduce,
            // 'owner_gmail' => $this->gmail_url,
            'owner_facebook' => @$this->fb_url,
            // 'owner_twitter' => $this->twitter_url,
            'owner_linkin' => @$this->linkin_url,
            // 'owner_zalo' => $this->zalo_url,
            'owner_github' => @$this->github_url,
            'created_at' => @$this->created_at,
            'updated_at' => @$this->updated_at,
        ];
    }
}
