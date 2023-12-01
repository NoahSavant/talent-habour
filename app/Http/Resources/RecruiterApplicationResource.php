<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecruiterApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id, 
            'title' => $this->recruitmentPost->title,
            'user' => new UserInformation($this->user),
            'status' => $this->status
        ];
    }
}
