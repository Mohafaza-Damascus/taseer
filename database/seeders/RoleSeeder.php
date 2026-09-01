<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin' => [
                'name' => 'مدير النظام',
                'permissions' => [
                    'projects.create',
                    'projects.update',
                    'projects.delete',

                    'pricing_items.create',
                    'pricing_items.update',
                    'pricing_items.delete',

                    'users.manage',

                    'projects.view',
                ],
            ],

            'manager' => [
                'name' => 'مدير',
                'permissions' => [
                    'projects.create',
                    'projects.update',

                    'pricing_items.create',

                    'projects.view',
                ],
            ],

            'data-entry' => [
                'name' => 'مدخل بيانات',
                'permissions' => [
                    'projects.create',
                    'pricing_items.create',

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

            $permissionIds = [];

            foreach ($data['permissions'] as $permissionSlug) {
                $permission = \App\Models\Permission::where(
                    'slug',
                    $permissionSlug
                )->first();

                if ($permission) {
                    $permissionIds[] = $permission->id;
                }
            }

            $role->permissions()->sync($permissionIds);
        }
    }
}