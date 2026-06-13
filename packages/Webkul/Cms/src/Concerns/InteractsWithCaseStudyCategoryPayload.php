<?php

namespace Webkul\Cms\Concerns;

trait InteractsWithCaseStudyCategoryPayload
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function sanitizePayload(array $data): array
    {
        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        return $data;
    }
}
