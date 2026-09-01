<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'إنشاء مشروع',
                'slug' => 'projects.create',
            ],
            [
                'name' => 'تعديل مشروع',
                'slug' => 'projects.update',
            ],
            [
                'name' => 'حذف مشروع',
                'slug' => 'projects.delete',
            ],
            [
                'name' => 'إضافة بند',
                'slug' => 'pricing_items.create',
            ],
            [
                'name' => 'تعديل بند',
                'slug' => 'pricing_items.update',
            ],
            [
                'name' => 'حذف بند',
                'slug' => 'pricing_items.delete',
            ],
            [
                'name' => 'إدارة المستخدمين',
                'slug' => 'users.manage',
            ],
            [
                'name' => 'مشاهدة المشاريع',
                'slug' => 'projects.view',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                ['name' => $permission['name']]
            );
        }
    }
}