<?php

namespace Webkul\Cms\Concerns;

trait InteractsWithServicePayload
{
    /**
     * @return array<string, string>
     */
    private function supportedLocales(): array
    {
        return ['en' => 'English', 'ar' => 'Arabic'];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function sanitizePayload(array $data): array
    {
        $data['is_active'] = (bool) ($data['is_active'] ?? false);
        $data['order'] = (int) ($data['order'] ?? 0);
        $data['icon'] = isset($data['icon']) && $data['icon'] !== ''
            ? $data['icon']
            : null;

        $translations = [];
        $allowedLocales = array_keys($this->supportedLocales());

        foreach (($data['translations'] ?? []) as $locale => $payload) {
            if (! in_array($locale, $allowedLocales, true) || ! is_array($payload)) {
                continue;
            }

            $translations[$locale] = [
                'title'         => $payload['title'] ?? '',
                'sub_title'     => $payload['sub_title'] ?? null,
                'problems'      => $payload['problems'] ?? null,
                'solutions'     => $payload['solutions'] ?? null,
                'key_benefits'  => $payload['key_benefits'] ?? null,
                'deliverables'  => $payload['deliverables'] ?? null,
                'locale'        => $locale,
            ];
        }

        unset($data['translations']);

        return $data + $translations;
    }
}
