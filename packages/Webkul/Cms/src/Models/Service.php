<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Webkul\Cms\Contracts\Service as ServiceContract;
use Webkul\Core\Eloquent\TranslatableModel;
use Webkul\Company\Models\Company;

class Service extends TranslatableModel implements HasMedia, ServiceContract
{
    use InteractsWithMedia, SoftDeletes;

    protected $table = 'cms_services';

    public array $translatedAttributes = [
        'title',
        'sub_title',
        'problems',
        'solutions',
        'key_benefits',
        'deliverables',
    ];

    protected $translationModel = ServiceTranslation::class;

    protected $translationForeignKey = 'cms_service_id';

    protected $fillable = [
        'cms_service_type_id',
        'name',
        'slug',
        'icon',
        'is_active',
        'order',
        'company_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class, 'cms_service_type_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main_media')->singleFile();
        $this->addMediaCollection('icon_media')->singleFile();
    }
}
