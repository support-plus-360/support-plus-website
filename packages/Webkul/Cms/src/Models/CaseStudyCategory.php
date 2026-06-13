<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webkul\Cms\Contracts\CaseStudyCategory as CaseStudyCategoryContract;
use Webkul\Company\Models\Company;

class CaseStudyCategory extends \Illuminate\Database\Eloquent\Model implements CaseStudyCategoryContract
{
    use SoftDeletes;

    protected $table = 'cms_case_study_categories';

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'company_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function caseStudies(): HasMany
    {
        return $this->hasMany(CaseStudy::class, 'cms_case_study_category_id');
    }
}
