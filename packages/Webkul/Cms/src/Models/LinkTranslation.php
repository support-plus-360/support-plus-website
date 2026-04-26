<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Cms\Contracts\LinkTranslation as LinkTranslationContract;

class LinkTranslation extends Model implements LinkTranslationContract
{
    protected $table = 'cms_link_translations';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'locale',
    ];
}
