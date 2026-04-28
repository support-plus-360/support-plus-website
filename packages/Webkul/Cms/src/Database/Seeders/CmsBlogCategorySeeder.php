<?php

namespace Webkul\Cms\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Webkul\Cms\Models\BlogCategory;

class CmsBlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlogCategory::create([
            'name' => 'Category 1',
            'slug' => 'category-1',
            'is_active' => true,
            'order' => 1,
            'company_id' => 1,
        ]);
    }
}
