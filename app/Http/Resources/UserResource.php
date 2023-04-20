<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // parent::toArray($request);

        return [
            'user_id' => $this->id,
            'user_name' => $this->name,
            'user_email' => $this->email,
            'user_avatar' => $this->profile_photo_url,
            'created_at' => Carbon::parse($this->created_at),
            'updated_at' => Carbon::parse($this->updated_at),
        ];
    }
}
