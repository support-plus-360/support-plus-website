<?php

namespace Webkul\Company\Repositories;

use Webkul\Core\Eloquent\Repository;

class CompanyRepository extends Repository
{
    public function model()
    {
        return \Webkul\Company\Contracts\Company::class;
    }
}

