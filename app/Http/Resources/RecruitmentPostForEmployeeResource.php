<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecruitmentPostForEmployeeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $applied = $this->applications->first(function ($application) {
            return $application->recruitment_post_id === $this->id and $application->user_id === auth()->user()->id;
        });

        $data = [
            'id' => $this->id,
            'user' => new UserInformation($this->user),
            'company' => $this->user->companyInformation,
            'role' => $this->role,
            'role_main' => $this->role_main,
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
            'number_application' => count($this->applications),
            'applied' => $applied === null ? false : true,
        ];

        return $data;
    }
}
