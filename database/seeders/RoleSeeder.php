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
                    'projects.view',

                    'pricing_items.create',

                    'contractors.view',
                    'contractors.create',
                    'contractors.update',
                    'contractors.delete',

                    'incoming_entities.create',

                    'related_works.create',
                ],
            ],

            'viewer' => [
                'name' => 'مشاهد',
                'permissions' => [
                    'projects.view',
                     'contractors.view',
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