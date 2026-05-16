<?php

namespace Webkul\Cms\Repositories;

use Webkul\Core\Eloquent\Repository;

class NavMenuRepository extends Repository
{
    public function model(): string
    {
        return \Webkul\Cms\Contracts\NavMenu::class;
    }
}
