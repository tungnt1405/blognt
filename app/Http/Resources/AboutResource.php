<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
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
        return [
            // 'owner_id' => $this->id,
            // 'owner_avatar' => $this->avatar,
            // 'owner_name' => $this->name,
            // 'owner_information' => $this->introduce,
            // 'owner_facebook' => $this->fb_url,
            // 'owner_linkin' => $this->linkin_url,
            // 'owner_github' => $this->github_url,
            // 'other_information' => [
            //     'owner_description' => $this->ownerInfo->description,
            //     'owner_project_join' => $this->ownerInfo->make_project,
            //     'owner_experience' => $this->ownerInfo->experience,
            //     'owner_career_goals' => $this->ownerInfo->career_goals,
            //     'created_at' => $this->ownerInfo->created_at,
            //     'updated_at' => $this->ownerInfo->updated_at,
            // ],
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
            'owner_id' => $this->id,
            'owner_info_id' => $this->ownerInfo->id,
            'owner_description' => $this->ownerInfo->description,
            'owner_project_join' => $this->ownerInfo->make_project,
            'owner_experience' => $this->ownerInfo->experience,
            'owner_career_goals' => $this->ownerInfo->career_goals,
            'created_at' => $this->ownerInfo->created_at,
            'updated_at' => $this->ownerInfo->updated_at,
        ];
    }
}
