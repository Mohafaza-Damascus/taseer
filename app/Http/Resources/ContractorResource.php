<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'name' => $this->name,

            'phone' => $this->phone,

            'national_number' => $this->national_number,

            'company_name' => $this->company_name,

            'created_at' => $this->created_at?->toISOString(),

            'updated_at' => $this->updated_at?->toISOString(),

            'projects' => $this->whenLoaded(
                'projects',
                function () {
                    return $this->projects->map(function ($project) {
                        return [
                            'id' => $project->id,
                            'name' => $project->name,
                        ];
                    });
                }
            ),
        ];
    }
}