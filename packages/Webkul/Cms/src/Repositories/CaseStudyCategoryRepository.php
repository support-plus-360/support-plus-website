<?php

namespace Webkul\Cms\Repositories;

use Webkul\Core\Eloquent\Repository;

class CaseStudyCategoryRepository extends Repository
{
    public function model()
    {
        return \Webkul\Cms\Contracts\CaseStudyCategory::class;
    }
}
