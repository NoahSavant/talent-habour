<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecruitmentPostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'user' => [
                'id' => $this->user->id,
                'fullname' => $this->user->fullname(),
                'image_url' => $this->user->image_url,
                'email' => $this->user->email
            ],
            'role' => $this->role,
            'title' => $this->title,
            'address' => $this->address,
            'job_type' => $this->job_type,
            'salary' => $this->salary,
            'description' => $this->description,
            'job_requirements' => $this->job_requirements,
            'educational_requirements' => $this->educational_requirements,
            'experience_requirements' => $this->experience_requirements,
            'expired_at' => $this->expired_at,
            'updated_at' => $this->updated_at
        ];

        return $data;
    }
}
