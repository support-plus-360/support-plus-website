<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webkul\Cms\Contracts\ServiceType as ServiceTypeContract;
use Webkul\Company\Models\Company;

class ServiceType extends \Illuminate\Database\Eloquent\Model implements ServiceTypeContract
{
    use SoftDeletes;

    protected $table = 'cms_service_types';

    protected $fillable = [
        'name',
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

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'cms_service_type_id');
    }
}
