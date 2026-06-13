<?php

namespace Webkul\Cms\Repositories;

use Webkul\Core\Eloquent\Repository;

class ServiceRepository extends Repository
{
    public function model()
    {
        return \Webkul\Cms\Contracts\Service::class;
    }

	public function findBySlug(string $slug)
	{
		return $this->model->where('slug', $slug)->first();
	}
}
