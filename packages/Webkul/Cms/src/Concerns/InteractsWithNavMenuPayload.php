<?php

namespace Webkul\Cms\Concerns;

trait InteractsWithNavMenuPayload
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function sanitizeNavMenuPayload(array $data): array
    {
        $data['key'] = strtolower(trim((string) ($data['key'] ?? '')));

        return $data;
    }
}
