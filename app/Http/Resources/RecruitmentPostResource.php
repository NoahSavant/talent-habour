<?php

namespace App\Http\Resources;

use App\Constants\UserConstant\UserRole;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecruitmentPostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $applied = $this->applications->first(function ($application) {
            return $application->recreuitment_post_id === $this->id and $application->user_id === $this->user->id;
        });

        $data = [
            'id' => $this->id,
            'user' => new UserInformation($this->user),
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
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'applied' => $applied === null ? false : true,
        ];

        return $data;
    }
}
