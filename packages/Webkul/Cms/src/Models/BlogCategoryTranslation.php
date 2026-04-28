<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Cms\Contracts\BlogCategoryTranslation as BlogCategoryTranslationContract;

class BlogCategoryTranslation extends Model implements BlogCategoryTranslationContract
{
    protected $table = 'cms_blog_category_translations';

    public $timestamps = true;

    protected $fillable = [
        'title',
        'description',
        'locale',
    ];
}