<?php

namespace Webkul\Cms\Concerns;

trait InteractsWithCaseStudyPayload
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

        $data['rate'] = $data['rate'] === null || $data['rate'] === ''
            ? null
            : (float) $data['rate'];

        $kpis = [];

        foreach (($data['kpis'] ?? []) as $row) {
            if (! is_array($row)) {
                continue;
            }

            $key = trim((string) ($row['key'] ?? ''));
            $value = trim((string) ($row['value'] ?? ''));

            if ($key !== '' || $value !== '') {
                $kpis[] = [
                    'key'   => $key,
                    'value' => $value,
                ];
            }
        }

        $data['kpis'] = $kpis === [] ? null : $kpis;

        $translations = [];
        $allowedLocales = array_keys($this->supportedLocales());

        foreach (($data['translations'] ?? []) as $locale => $payload) {
            if (! in_array($locale, $allowedLocales, true) || ! is_array($payload)) {
                continue;
            }

            $translations[$locale] = [
                'title'      => $payload['title'] ?? '',
                'sub_title'  => $payload['sub_title'] ?? null,
                'content'    => $payload['content'] ?? null,
                'challenges' => $payload['challenges'] ?? null,
                'solutions'  => $payload['solutions'] ?? null,
                'locale'     => $locale,
            ];
        }

        unset($data['translations']);

        return $data + $translations;
    }
}
