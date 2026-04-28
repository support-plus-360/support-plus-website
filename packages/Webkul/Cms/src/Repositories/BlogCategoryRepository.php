<?php

namespace Webkul\Cms\Repositories;

use Webkul\Core\Eloquent\Repository;

class BlogCategoryRepository extends Repository
{
    public function model()
    {
        return \Webkul\Cms\Contracts\BlogCategory::class;
    }
}
