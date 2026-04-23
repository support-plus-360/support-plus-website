<?php

namespace Webkul\Cms\Concerns;

trait InteractsWithItemPayload
{
    /**
     * Locale code => label for admin forms and payload filtering.
     *
     * @return array<string, string>
     */
    private function supportedLocales(): array
    {
        /**
         * Note: sections table currently stores locale as 2 chars.
         * Keeping it limited to 'en' and 'ar' to match migration.
         */
        return ['en' => 'English', 'ar' => 'Arabic'];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function sanitizePayload(array $data, bool $forceAuthor = false): array
    {
        $data['is_active'] = (bool) ($data['is_active'] ?? false);
        $data['order'] = (int) ($data['order'] ?? 0);

        if ($forceAuthor && empty($data['author_id']) && auth()->check()) {
            $data['author_id'] = auth()->id();
        }

        $translations = [];

        $allowedLocales = array_keys($this->supportedLocales());

        foreach (($data['translations'] ?? []) as $locale => $payload) {
            if (! in_array($locale, $allowedLocales, true)) {
                continue;
            }

            if (! is_array($payload)) {
                continue;
            }

            $translations[$locale] = [
                'title'            => $payload['title'] ?? '',
                'sub_title'        => $payload['sub_title'] ?? null,
                'content'          => $payload['content'] ?? null,
                'icon'             => $payload['icon'] ?? null,
                'locale'           => $locale,
            ];
        }

        return $data + $translations;
    }
}
