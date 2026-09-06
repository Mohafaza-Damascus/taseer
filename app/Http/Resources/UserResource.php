<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->when(
                $this->relationLoaded('roles'),
                function () {
                    $role = $this->roles->first();

                    if (!$role) {
                        return null;
                    }

                    return [
                        'id' => $role->id,
                        'name' => $role->name,
                        'slug' => $role->slug,
                    ];
                }
            ),

            'permissions' => $this->when(
                $this->relationLoaded('roles'),
                function () {
                    return $this->roles
                        ->flatMap(function ($role) {
                            return $role->permissions;
                        })
                        ->unique('id')
                        ->values()
                        ->map(function ($permission) {
                            return [
                                'id' => $permission->id,
                                'name' => $permission->name,
                                'slug' => $permission->slug,
                            ];
                        });
                }
            ),

            'created_at' => $this->created_at?->format(
                'Y-m-d H:i:s'
            ),

            'updated_at' => $this->updated_at?->format(
                'Y-m-d H:i:s'
            ),
        ];
    }
}