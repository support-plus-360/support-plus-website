<?php

namespace Webkul\Cms\Concerns;

trait InteractsWithBlogPostPayload
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
    protected function sanitizePayload(array $data, bool $forceAuthor = false): array
    {
        $data['is_active'] = (bool) ($data['is_active'] ?? false);
        $data['order'] = (int) ($data['order'] ?? 0);
        $data['is_featured'] = (bool) ($data['is_featured'] ?? false);
        $data['allow_comments'] = (bool) ($data['allow_comments'] ?? false);
        $data['is_indexable'] = (bool) ($data['is_indexable'] ?? true);
        $data['views_count'] = (int) ($data['views_count'] ?? 0);
        $data['reading_time_minutes'] = $data['reading_time_minutes'] === null || $data['reading_time_minutes'] === ''
            ? null
            : (int) $data['reading_time_minutes'];

        if ($forceAuthor && empty($data['author_id']) && auth()->check()) {
            $data['author_id'] = auth()->id();
        }

        $translations = [];
        $allowedLocales = array_keys($this->supportedLocales());

        foreach (($data['translations'] ?? []) as $locale => $payload) {
            if (! in_array($locale, $allowedLocales, true) || ! is_array($payload)) {
                continue;
            }

            $translations[$locale] = [
                'title'            => $payload['title'] ?? '',
                'excerpt'          => $payload['excerpt'] ?? null,
                'content'          => $payload['content'] ?? null,
                'meta_title'       => $payload['meta_title'] ?? null,
                'meta_description' => $payload['meta_description'] ?? null,
                'meta_keywords'    => $payload['meta_keywords'] ?? null,
                'og_title'         => $payload['og_title'] ?? null,
                'og_description'   => $payload['og_description'] ?? null,
                'locale'           => $locale,
            ];
        }

        unset($data['translations']);

        return $data + $translations;
    }
}
