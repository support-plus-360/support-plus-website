<?php

namespace Webkul\Cms\Concerns;

trait InteractsWithNavItemPayload
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
    protected function sanitizeNavItemPayload(array $data): array
    {
        $data['is_active'] = (bool) ($data['is_active'] ?? false);
        $data['open_in_new_tab'] = (bool) ($data['open_in_new_tab'] ?? false);
        $data['order'] = (int) ($data['order'] ?? 0);
        $data['parent_id'] = filled($data['parent_id'] ?? null) ? (int) $data['parent_id'] : null;
        $data['cms_page_id'] = filled($data['cms_page_id'] ?? null) ? (int) $data['cms_page_id'] : null;
        $data['url'] = filled($data['url'] ?? null) ? trim((string) $data['url']) : null;

        $translations = [];
        $allowedLocales = array_keys($this->supportedLocales());

        foreach (($data['translations'] ?? []) as $locale => $payload) {
            if (! in_array($locale, $allowedLocales, true) || ! is_array($payload)) {
                continue;
            }

            $label = isset($payload['label']) ? trim((string) $payload['label']) : '';

            $translations[$locale] = [
                'label'  => $label !== '' ? $label : null,
                'locale' => $locale,
            ];
        }

        unset($data['translations']);

        return $data + $translations;
    }
}
