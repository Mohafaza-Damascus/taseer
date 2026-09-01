<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin' => [
                'name' => 'مدير النظام',
                'permissions' => 'all',
            ],

            'employee' => [
                'name' => 'موظف',
                'permissions' => [
                    'projects.create',

                    'pricing_items.create',

                    'contractors.create',

                    'incoming_entities.create',

                    'related_works.create',

                    'projects.view',
                ],
            ],

            'viewer' => [
                'name' => 'مشاهد',
                'permissions' => [
                    'projects.view',
                ],
            ],
        ];

        foreach ($roles as $slug => $data) {
            $role = Role::updateOrCreate(
                ['slug' => $slug],
                ['name' => $data['name']]
            );

            if ($data['permissions'] === 'all') {
                $permissionIds = Permission::pluck('id')->toArray();
            } else {
                $permissionIds = Permission::whereIn(
                    'slug',
                    $data['permissions']
                )->pluck('id')->toArray();
            }

            $role->permissions()->sync($permissionIds);
        }
    }
}