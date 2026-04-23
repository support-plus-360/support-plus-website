<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Cms\Contracts\ItemTranslation as ItemTranslationContract;

class ItemTranslation extends Model implements ItemTranslationContract
{
    protected $table = 'cms_item_translations';

    public $timestamps = true;

    protected $fillable = [
        'title',
        'sub_title',
        'content',
        'icon',
        'meta_keywords',
        'locale',
    ];
}

