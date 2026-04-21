<?php

namespace Webkul\Cms\Repositories;

use Webkul\Core\Eloquent\Repository;

class PageRepository extends Repository
{
    public function model()
    {
        return \Webkul\Cms\Contracts\Page::class;
    }
}

