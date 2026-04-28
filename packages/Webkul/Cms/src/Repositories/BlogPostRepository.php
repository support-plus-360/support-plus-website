<?php

namespace Webkul\Cms\Repositories;

use Webkul\Core\Eloquent\Repository;

class BlogPostRepository extends Repository
{
    public function model()
    {
        return \Webkul\Cms\Contracts\BlogPost::class;
    }
}
