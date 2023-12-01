<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id, 
            'title' => $this->recruitmentPost->title,
            'logo_url' => $this->recruitmentPost->user->companyInformation->logo_url,
            'company' => $this->recruitmentPost->user->companyInformation->name,
            'salary' => $this->recruitmentPost->salary,
            'status' => $this->status
        ];
    }
}
