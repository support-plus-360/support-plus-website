<?php

namespace Webkul\Cms\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Webkul\Cms\Models\Page;

class CmsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Page::create([
            'slug' => 'page-1',
            'name' => 'Page 1',
            'is_active' => true,
            'order' => 1,
            'company_id' => 1,
        ]);
        Page::create([
            'slug' => 'page-2',
            'name' => 'Page 2',
            'is_active' => true,
            'order' => 2,
            'company_id' => 1,
        ]);
        Page::create([
            'slug' => 'page-3',
            'name' => 'Page 3',
            'is_active' => true,
            'order' => 3,
            'company_id' => 1,
        ]);
    }
}
