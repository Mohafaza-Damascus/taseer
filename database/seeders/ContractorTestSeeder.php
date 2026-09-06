<?php

namespace Database\Seeders;

use App\Models\Contractor;
use Illuminate\Database\Seeder;

class ContractorTestSeeder extends Seeder
{
    public function run(): void
    {
        Contractor::updateOrCreate(
            [
                'national_number' => '01012345678',
            ],
            [
                'name' =>
                    'شركة الإعمار للمقاولات',

                'phone' =>
                    '0991234567',

                'company_name' =>
                    'شركة الإعمار للمقاولات',
            ]
        );

        Contractor::updateOrCreate(
            [
                'national_number' => '01087654321',
            ],
            [
                'name' =>
                    'مؤسسة البناء الحديث',

                'phone' =>
                    '0987654321',

                'company_name' =>
                    'مؤسسة البناء الحديث',
            ]
        );
    }
}