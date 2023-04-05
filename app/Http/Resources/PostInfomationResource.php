<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PostInfomationResource extends JsonResource
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
            'post_information_id' => $this->id,
            'post_id' => $this->post_id,
            'post_status' => $this->status ? true : false,
            'post_publish' => Carbon::parse($this->public_date),
        ];
    }
}
