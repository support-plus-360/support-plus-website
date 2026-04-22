<?php

namespace Webkul\Company\Concerns;

trait InteractsWithCompanyPayload
{
    protected function sanitizePayload(array $data): array
    {
        $data['address'] = (array) ($data['address'] ?? []);
        $data['configs'] = (array) ($data['configs'] ?? []);
        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        return $data;
    }
}

           
