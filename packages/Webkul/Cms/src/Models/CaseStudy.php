<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Webkul\Cms\Contracts\CaseStudy as CaseStudyContract;
use Webkul\Core\Eloquent\TranslatableModel;
use Webkul\Company\Models\Company;

class CaseStudy extends TranslatableModel implements HasMedia, CaseStudyContract
{
    use InteractsWithMedia, SoftDeletes;

    protected $table = 'cms_case_studies';

    public array $translatedAttributes = [
        'title',
        'sub_title',
        'content',
        'challenges',
        'solutions',
    ];

    protected $translationModel = CaseStudyTranslation::class;

    protected $translationForeignKey = 'cms_case_study_id';

    protected $fillable = [
        'cms_case_study_category_id',
        'city',
        'kpis',
        'rate',
        'is_active',
        'is_featured',
        'order',
        'company_id',
    ];

    protected $casts = [
        'kpis'      => 'array',
        'rate'      => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'order'     => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(CaseStudyCategory::class, 'cms_case_study_category_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
