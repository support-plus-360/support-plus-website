<?php

namespace Webkul\Cms\Repositories;

use Webkul\Core\Eloquent\Repository;

class ItemRepository extends Repository
{
    public function model()
    {
        return \Webkul\Cms\Contracts\Item::class;
    }
}

