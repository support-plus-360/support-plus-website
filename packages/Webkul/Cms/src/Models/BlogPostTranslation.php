<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Cms\Contracts\BlogPostTranslation as BlogPostTranslationContract;

class BlogPostTranslation extends Model implements BlogPostTranslationContract
{
    protected $table = 'cms_blog_post_translations';

    public $timestamps = true;

    protected $fillable = [
        'title',
        'excerpt',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'locale',
    ];
}
