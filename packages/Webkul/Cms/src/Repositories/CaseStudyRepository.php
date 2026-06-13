<?php

namespace Webkul\Cms\Repositories;

use Webkul\Core\Eloquent\Repository;

class CaseStudyRepository extends Repository
{
    public function model()
    {
        return \Webkul\Cms\Contracts\CaseStudy::class;
    }

    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->first();
        $caseStudy->loadMissing('translations', 'category', 'media');

        return $caseStudy;
    }
}
