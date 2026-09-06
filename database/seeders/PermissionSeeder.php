<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'إنشاء مشروع', 'slug' => 'projects.create'],
            ['name' => 'تعديل مشروع', 'slug' => 'projects.update'],
            ['name' => 'حذف مشروع', 'slug' => 'projects.delete'],
            ['name' => 'مشاهدة المشاريع', 'slug' => 'projects.view'],

            ['name' => 'إضافة بند', 'slug' => 'pricing_items.create'],
            ['name' => 'تعديل بند', 'slug' => 'pricing_items.update'],
            ['name' => 'حذف بند', 'slug' => 'pricing_items.delete'],

            ['name' => 'مشاهدة المتعهدين', 'slug' => 'contractors.view'],
            ['name' => 'إضافة متعهد', 'slug' => 'contractors.create'],
            ['name' => 'تعديل متعهد', 'slug' => 'contractors.update'],
            ['name' => 'حذف متعهد', 'slug' => 'contractors.delete'],

            ['name' => 'إضافة جهة واردة', 'slug' => 'incoming_entities.create'],
            ['name' => 'تعديل جهة واردة', 'slug' => 'incoming_entities.update'],
            ['name' => 'حذف جهة واردة', 'slug' => 'incoming_entities.delete'],

            ['name' => 'إضافة عمل مرتبط', 'slug' => 'related_works.create'],
            ['name' => 'تعديل عمل مرتبط', 'slug' => 'related_works.update'],
            ['name' => 'حذف عمل مرتبط', 'slug' => 'related_works.delete'],

            ['name' => 'إدارة المستخدمين', 'slug' => 'users.manage'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                ['name' => $permission['name']]
            );
        }
    }
}