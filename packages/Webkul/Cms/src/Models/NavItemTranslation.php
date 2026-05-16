<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Cms\Contracts\NavItemTranslation as NavItemTranslationContract;

class NavItemTranslation extends Model implements NavItemTranslationContract
{
    protected $table = 'cms_nav_item_translations';

    public $timestamps = true;

    protected $fillable = [
        'label',
        'locale',
    ];
}
