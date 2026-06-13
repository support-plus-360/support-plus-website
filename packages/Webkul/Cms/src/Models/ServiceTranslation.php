<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Cms\Contracts\ServiceTranslation as ServiceTranslationContract;

class ServiceTranslation extends Model implements ServiceTranslationContract
{
    protected $table = 'cms_service_translations';

    public $timestamps = true;

    protected $fillable = [
        'title',
        'sub_title',
        'problems',
        'solutions',
        'key_benefits',
        'deliverables',
        'locale',
    ];
}
