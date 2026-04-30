<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Webkul\Cms\Contracts\Section as SectionContract;
use Webkul\Core\Eloquent\TranslatableModel;
use Webkul\Company\Models\Company;

class Section extends TranslatableModel implements HasMedia, SectionContract
{
    use InteractsWithMedia, SoftDeletes;

    protected $table = 'cms_sections';

    /**
     * Astrotomic\Translatable config.
     */
    public array $translatedAttributes = [
        'title',
        'subtitle',
        'description',
    ];

    protected $translationModel = SectionTranslation::class;

    protected $translationForeignKey = 'cms_section_id';

    protected $fillable = [
        'page_id',
        'name',
        'type',
        'template',
        'settings',
        'order',
        'is_active',
        'company_id',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'order'        => 'integer',
	'settings'     => 'array',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}

