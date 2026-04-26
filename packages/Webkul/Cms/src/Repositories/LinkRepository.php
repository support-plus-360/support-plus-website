<?php

namespace Webkul\Cms\Repositories;

use Webkul\Core\Eloquent\Repository;

class LinkRepository extends Repository
{
    public function model()
    {
        return \Webkul\Cms\Contracts\Link::class;
    }
}
