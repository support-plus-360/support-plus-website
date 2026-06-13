<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Cms\Contracts\CaseStudyTranslation as CaseStudyTranslationContract;

class CaseStudyTranslation extends Model implements CaseStudyTranslationContract
{
    protected $table = 'cms_case_study_translations';

    public $timestamps = true;

    protected $fillable = [
        'title',
        'sub_title',
        'content',
        'challenges',
        'solutions',
        'locale',
    ];
}
