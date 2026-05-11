<?php

namespace Webkul\Cms\Support;

use Illuminate\Support\Facades\File;

class SectionLayoutPreview
{
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
     * Resolve preview image URL for the builder (config value from cms_section_layout_renderers).
     *
     * Relative filenames: prefer `public/vendor/webkul/cms/builder-layout-previews/` (publish),
     * then the package `Resources/assets/builder-layout-previews/` via an admin route so PNG/SVG
     * in the package still load without copying to public.
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

        $file = basename(str_replace('\\', '/', $value));
        if ($file === '' || $file === '.' || $file === '..') {
            return null;
        }

        $publicPath = self::publicPreviewDirectory().'/'.$file;
        if (File::isFile($publicPath)) {
            return asset('vendor/webkul/cms/builder-layout-previews/'.$file);
        }

        $packagePath = self::packagePreviewDirectory().'/'.$file;
        if (File::isFile($packagePath)) {
            return route('admin.cms.builder.layout-preview', ['filename' => $file], true);
        }

        return asset('vendor/webkul/cms/builder-layout-previews/'.$file);
    }

    /**
     * Payload for window.__CMS_SECTION_LAYOUT_PREVIEW__ (per layout key).
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
}
