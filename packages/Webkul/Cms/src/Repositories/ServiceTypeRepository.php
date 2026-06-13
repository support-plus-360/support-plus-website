<?php

namespace Webkul\Cms\Repositories;

use Webkul\Core\Eloquent\Repository;

class ServiceTypeRepository extends Repository
{
    public function model()
    {
        return \Webkul\Cms\Contracts\ServiceType::class;
    }
}
