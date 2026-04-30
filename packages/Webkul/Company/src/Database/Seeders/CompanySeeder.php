<?php

namespace Webkul\Company\Database\Seeders;

use Illuminate\Database\Seeder;
use Webkul\Company\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'Support Plus 360',
            'short_name' => 'SP360',
            'website' => 'https://supportplus360.com',
            'address' => json_encode([]),
            'is_active' => true,
            'configs' => json_encode([]),
        ]);

		Company::create([
            'name' => 'Mena Support Plus',
            'short_name' => 'MSP',
            'website' => 'https://menasupportplus.com',
            'address' => json_encode([]),
            'is_active' => true,
            'configs' => json_encode([]),
        ]);
    }
}
