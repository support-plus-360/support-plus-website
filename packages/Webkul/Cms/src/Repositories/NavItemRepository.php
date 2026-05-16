<?php

namespace Webkul\Cms\Repositories;

use Webkul\Core\Eloquent\Repository;

class NavItemRepository extends Repository
{
    public function model(): string
    {
        return \Webkul\Cms\Contracts\NavItem::class;
    }
}
