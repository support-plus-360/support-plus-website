<?php

namespace Webkul\Cms\Repositories;

use Webkul\Core\Eloquent\Repository;

class SectionRepository extends Repository
{
    public function model()
    {
        return \Webkul\Cms\Contracts\Section::class;
    }
}

