<?php

namespace Webkul\Cms\Database\Seeders;

use Illuminate\Database\Seeder;
use Webkul\Cms\Models\BlogPost;

class CmsBlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $en = [
            'title'            => 'Post 1',
            'content'          => 'Content 1',
            'meta_title'       => 'Meta Title 1',
            'meta_description' => 'Meta Description 1',
            'meta_keywords'    => 'Meta Keywords 1',
        ];
        $ar = [
            'title'   => 'Post 1',
            'content' => 'Content 1',
        ];

        $p1 = BlogPost::create([
            'slug'         => 'post-1',
            'status'       => 'published',
            'is_active'    => true,
            'order'        => 1,
            'company_id'   => 1,
            'author_id'    => 1,
            'published_at' => now(),
            'views_count'  => 0,
            'en'           => $en,
            'ar'           => $ar,
        ]);
        $p1->blogCategories()->sync([1]);

        $en2 = array_merge($en, [
            'title'   => 'Post 2',
            'content' => 'Content 2',
        ]);
        $p2 = BlogPost::create([
            'slug'         => 'post-2',
            'status'       => 'published',
            'is_active'    => true,
            'order'        => 2,
            'company_id'   => 1,
            'author_id'    => 1,
            'published_at' => now(),
            'views_count'  => 0,
            'en'           => $en2,
            'ar'           => array_merge($ar, ['title' => 'Post 2', 'content' => 'Content 2']),
        ]);
        $p2->blogCategories()->sync([1]);

        $en3 = array_merge($en, [
            'title'   => 'Post 3',
            'content' => 'Content 3',
        ]);
        $p3 = BlogPost::create([
            'slug'         => 'post-3',
            'status'       => 'published',
            'is_active'    => true,
            'order'        => 3,
            'company_id'   => 1,
            'author_id'    => 1,
            'published_at' => now(),
            'views_count'  => 0,
            'en'           => $en3,
            'ar'           => array_merge($ar, ['title' => 'Post 3', 'content' => 'Content 3']),
        ]);
        $p3->blogCategories()->sync([1]);
    }
}
