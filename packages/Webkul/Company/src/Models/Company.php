<?php

namespace Webkul\Company\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webkul\Company\Contracts\Company as CompanyContract;

class Company extends Model implements CompanyContract {

	use SoftDeletes;

	protected $table = 'companies';

    protected $casts = [
        'address' => 'array',
        'configs' => 'array',
		'is_active' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'short_name',
        'website',
        'address',
	'configs',
	'is_active',
	];


}