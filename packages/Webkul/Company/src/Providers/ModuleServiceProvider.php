<?php

namespace Webkul\Company\Providers;

use Webkul\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    public function register()
    {
        parent::register();

        $this->app->register(CompanyServiceProvider::class);
    }

    /**
     * The models to be used by this module.
     *
     * @var array
     */
    protected $models = [
        //
	\Webkul\Company\Models\Company::class,
    ];
}
