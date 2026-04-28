<?php

namespace Webkul\Cms\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Webkul\Cms\Models\Section;

class CmsSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::create([
            'name' => 'Section 1',
            'type' => 'default',
            'settings' => [],
            'is_active' => true,
            'order' => 1,
            'company_id' => 1,
            'page_id' => 1,
        ]);
        	Section::create([
            'name' => 'Section 2',
            'type' => 'hero',
            'settings' => [],
            'order' => 2,
            'company_id' => 1,
            'page_id' => 1,
        ]);
        Section::create([
            'name' => 'Section 3',
            'type' => 'gallery',
            'settings' => [],
            'order' => 3,
            'company_id' => 1,
            'page_id' => 1,
        ]);
    }
}
