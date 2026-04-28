<?php

namespace Webkul\Cms\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Webkul\Cms\Models\Link;
use Webkul\Cms\Models\Page;
use Webkul\Cms\Models\Section;
use Webkul\Cms\Models\Item;

class CmsLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Link::create([
            'linkable_id' => 1,
            'linkable_type' => Page::class,
            'name' => 'Link 1',
            'link' => 'https://www.google.com',
            'icon' => 'fa-google',
            'target' => '_self',
            'type' => 'social',
            'order' => 1,
            'is_active' => true,
            'company_id' => 1,
        ]);
        Link::create([
            'linkable_id' => 1,
            'linkable_type' => Section::class,
            'name' => 'Link 2',
            'link' => 'https://www.google.com',
            'icon' => 'fa-google',
            'target' => '_self',
            'type' => 'social',
            'order' => 2,
            'is_active' => true,
            'company_id' => 1,
        ]);
        Link::create([
            'linkable_id' => 1,
            'linkable_type' => Item::class,
            'name' => 'Link 3',
            'link' => 'https://www.google.com',
            'icon' => 'fa-google',
            'target' => '_self',
            'type' => 'social',
            'order' => 3,
            'is_active' => true,
            'company_id' => 1,
        ]);
    }
}
