<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Cms\Contracts\SectionTranslation as SectionTranslationContract;

class SectionTranslation extends Model implements SectionTranslationContract
{
    protected $table = 'cms_section_translations';

    public $timestamps = true;

    protected $fillable = [
        'locale',
        'title',
        'subtitle',
        'description',
    ];
}

