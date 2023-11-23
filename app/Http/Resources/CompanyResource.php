<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id, 
            'name' => $this->name,
            'logo' => $this->logo,
            'address_main' => $this->address_main,
            'field' => $this->field,
        ];
    }
}
