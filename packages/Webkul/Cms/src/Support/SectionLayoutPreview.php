<?php

namespace Webkul\Cms\Support;

use Illuminate\Support\Facades\File;

class SectionLayoutPreview
{
    public const PREVIEW_SUBDIRECTORY = 'v1';

    /**
     * Package directory for default layout preview assets (SVG/PNG you ship with the package).
     */
    public static function packagePreviewDirectory(): string
    {
        return dirname(__DIR__).'/Resources/assets/builder-layout-previews';
    }

    /**
     * Published / overridden previews under the application public directory.
     */
    public static function publicPreviewDirectory(): string
    {
        return public_path('vendor/webkul/cms/builder-layout-previews');
    }

    /**
     * Normalize config value to a safe relative path under builder-layout-previews (e.g. v1/hero.png).
     */
    public static function normalizeRelativePreviewPath(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        $path = str_replace('\\', '/', trim($value));
        $path = ltrim($path, '/');

        if ($path === '' || str_contains($path, '..')) {
            return null;
        }

        if (! str_contains($path, '/')) {
            $path = self::PREVIEW_SUBDIRECTORY.'/'.$path;
        }

        if (! preg_match('#^v1/[a-zA-Z0-9._-]+\.(png|svg|webp)$#', $path)) {
            return null;
        }

        return $path;
    }

    /**
     * Resolve preview image URL for the builder (config value from cms_section_layout_renderers).
     *
     * Relative filenames resolve to `builder-layout-previews/v1/` in public publish or package assets.
     */
    public static function resolveImageUrl(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (preg_match('#^https?://#i', $value)) {
            return $value;
        }

        if (str_starts_with($value, '/')) {
            return url($value);
        }

        $file = self::normalizeRelativePreviewPath($value);

        if ($file === null) {
            return null;
        }

        $publicPath = self::publicPreviewDirectory().'/'.$file;
        if (File::isFile($publicPath)) {
            return asset('vendor/webkul/cms/builder-layout-previews/'.$file);
        }

        $packagePath = self::packagePreviewDirectory().'/'.$file;
        if (File::isFile($packagePath)) {
            return route('admin.cms.builder.layout-preview', ['path' => $file], true);
        }

        return asset('vendor/webkul/cms/builder-layout-previews/'.$file);
    }

    /**
     * Lightweight builder payload (preview thumbs only — no HTML templates).
     *
     * @param  array<string, array<string, mixed>>  $layoutKeys
     * @return array<string, array{preview_image: ?string, preview_caption: string}>
     */
    public static function thumbPayload(array $layoutKeys): array
    {
        $renderers = config('cms.section_layout_renderers', []);
        $out = [];

        foreach (array_keys($layoutKeys) as $key) {
            $meta = $renderers[$key] ?? [];
            $out[$key] = [
                'preview_image'   => self::resolveImageUrl($meta['preview_image'] ?? null),
                'preview_caption' => (string) ($meta['preview_caption'] ?? ''),
            ];
        }

        return $out;
    }

    /**
     * Full payload including live-preview templates (large — avoid inlining in builder HTML).
     *
     * @param  array<string, array<string, mixed>>  $layoutKeys  Keys from section_layouts.layouts
     * @return array<string, array{preview_image: ?string, preview_caption: string, templates: array<string, string>}>
     */
    public static function scriptPayload(array $layoutKeys): array
    {
        $renderers = config('cms.section_layout_renderers', []);
        $out = [];

        foreach (array_keys($layoutKeys) as $key) {
            $meta = $renderers[$key] ?? [];
            $out[$key] = [
                'preview_image'   => self::resolveImageUrl($meta['preview_image'] ?? null),
                'preview_caption' => (string) ($meta['preview_caption'] ?? ''),
                'templates'       => is_array($meta['templates'] ?? null) ? $meta['templates'] : [],
            ];
        }

        return $out;
    }

    /**
     * JSON for the page builder (loaded via fetch — keeps the HTML response small).
     *
     * @param  array<string, array<string, mixed>>  $layoutKeys
     * @return array{layouts: array<string, array{preview_image: ?string, preview_caption: string}>, fallback: string, guide: list<array{key: string, label: string, description: string, preview_image: ?string, preview_caption: string}>}
     */
    public static function builderConfigPayload(array $layoutKeys, string $fallback): array
    {
        $thumbs = self::thumbPayload($layoutKeys);
        $guide = [];

        foreach ($layoutKeys as $layoutKey => $layoutMeta) {
            $preview = $thumbs[$layoutKey] ?? [];
            $guide[] = [
                'key'             => $layoutKey,
                'label'           => $layoutMeta['label'] ?? $layoutKey,
                'description'     => $layoutMeta['description'] ?? '',
                'preview_image'   => $preview['preview_image'] ?? null,
                'preview_caption' => $preview['preview_caption'] ?? ($layoutMeta['description'] ?? ''),
            ];
        }

        return [
            'layouts'  => $thumbs,
            'fallback' => $fallback,
            'guide'    => $guide,
        ];
    }
}
