<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Cms\Contracts\PageTranslation as PageTranslationContract;

class PageTranslation extends Model implements PageTranslationContract
{
    protected $table = 'cms_page_translations';

    public $timestamps = true;

    protected $fillable = [
        'title',
        'meta_description',
        'meta_keywords',
        'locale',
    ];
}

