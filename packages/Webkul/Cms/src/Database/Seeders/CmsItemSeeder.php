<?php

namespace Webkul\Cms\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Webkul\Cms\Models\Item;

class CmsItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::create([
            'section_id' => 1,
            'type' => 'default',
            'settings' => null,
            'order' => 1,
            'company_id' => 1,
        ]);
        Item::create([
            'section_id' => 1,
            'type' => 'card',
            'settings' => null,
            'order' => 2,
            'company_id' => 1,
        ]);
        Item::create([
            'section_id' => 1,
            'type' => 'feature',
            'settings' => null,
            'order' => 3,
            'company_id' => 1,
        ]);
    }
}
