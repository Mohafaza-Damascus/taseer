<?php

namespace Database\Seeders;

use App\Models\Contractor;
use App\Models\IncomingEntity;
use App\Models\PricingItem;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectTestSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            /*
            |--------------------------------------------------------------------------
            | Incoming Entity
            |--------------------------------------------------------------------------
            */

            $incomingEntity = IncomingEntity::updateOrCreate(
                ['id' => 1],
                [
                    'name' => 'وزارة الإدارة المحلية',
                    'notes' => 'جهة واردة تجريبية لاختبار المشاريع',
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | Contractor
            |--------------------------------------------------------------------------
            */

            $contractor = Contractor::updateOrCreate(
                ['id' => 1],
                [
                    'name' => 'شركة الإعمار للمقاولات',
                    'phone' => '0991234567',
                    'national_number' => '01012345678',
                    'company_name' => 'شركة الإعمار للمقاولات',
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | Pricing Items
            |--------------------------------------------------------------------------
            */

            $pricingItem1 = PricingItem::updateOrCreate(
                ['id' => 1],
                [
                    'name' => 'توريد إسمنت',
                    'unit' => 'طن',
                    'related_work_id' => null,
                ]
            );

            $pricingItem2 = PricingItem::updateOrCreate(
                ['id' => 2],
                [
                    'name' => 'توريد حديد',
                    'unit' => 'طن',
                    'related_work_id' => null,
                ]
            );



            /*
            |--------------------------------------------------------------------------
            | Project
            |--------------------------------------------------------------------------
            */

            $project = Project::updateOrCreate(
                ['name' => 'مشروع إنشاء مبنى إداري'],
                [
                    'signing_location' => 'دمشق',
                    'start_date' => '2026-09-01',
                    'end_date' => '2027-09-01',
                    'incoming_entity_id' => $incomingEntity->id,
                    'contractor_id' => $contractor->id,
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | Project Pricing Items
            |--------------------------------------------------------------------------
            */

            $project->pricingItems()->sync([
                $pricingItem1->id => [
                    'quantity' => 100,
                    'unit_price_syp' => 500000,
                    'unit_price_usd' => 50,
                    'specifications' => json_encode([
                        'material' => 'إسمنت',
                        'brand' => 'نوع أول',
                    ], JSON_UNESCAPED_UNICODE),
                ],

                $pricingItem2->id => [
                    'quantity' => 25.5,
                    'unit_price_syp' => 750000,
                    'unit_price_usd' => 75,
                    'specifications' => json_encode([
                        'material' => 'حديد',
                        'diameter' => '12mm',
                    ], JSON_UNESCAPED_UNICODE),
                ],
            ]);
        });
    }
}