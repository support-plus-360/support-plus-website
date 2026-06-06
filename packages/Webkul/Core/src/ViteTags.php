<?php

namespace Webkul\Core;

use Illuminate\Support\HtmlString;

class ViteTags
{
    /**
     * Render admin Vite entry tags by reading manifest.json from disk on every request.
     */
    public static function admin(array $entryPoints): HtmlString
    {
        $namespace = 'admin';
        $hotFile = public_path(config("krayin-vite.viters.{$namespace}.hot_file", 'admin-vite.hot'));

        if (is_file($hotFile)) {
            ViteManifest::clearCache();

            return vite()->set($entryPoints, $namespace);
        }

        $manifest = ViteManifest::read($namespace);

        if ($manifest === null) {
            ViteManifest::clearCache();

            return vite()->set($entryPoints, $namespace);
        }

        $buildDirectory = config("krayin-vite.viters.{$namespace}.build_directory", 'admin/build');
        $base = rtrim(asset($buildDirectory), '/');
        $version = $manifest['mtime'];
        $tags = [];
        $emitted = [];

        foreach ($entryPoints as $entrypoint) {
            $chunk = $manifest['data'][$entrypoint] ?? null;

            if (! is_array($chunk)) {
                continue;
            }

            foreach ($chunk['css'] ?? [] as $cssFile) {
                self::pushStylesheet($tags, $emitted, $base.'/'.$cssFile, $version);
            }

            $file = $chunk['file'] ?? '';

            if (is_string($file) && str_ends_with($file, '.css')) {
                self::pushStylesheet($tags, $emitted, $base.'/'.$file, $version);
            } elseif (is_string($file) && str_ends_with($file, '.js')) {
                $url = $base.'/'.$file.'?v='.$version;

                if (! isset($emitted[$url])) {
                    $tags[] = '<script type="module" src="'.e($url).'"></script>';
                    $emitted[$url] = true;
                }
            }
        }

        return new HtmlString(implode('', $tags));
    }

    /**
     * Resolve a built asset URL with manifest mtime cache-busting.
     */
    public static function adminAsset(string $filename, string $namespace = 'admin'): string
    {
        $hotFile = public_path(config("krayin-vite.viters.{$namespace}.hot_file", 'admin-vite.hot'));

        if (is_file($hotFile)) {
            ViteManifest::clearCache();

            return vite()->asset($filename, $namespace);
        }

        $manifest = ViteManifest::read($namespace);

        if ($manifest === null) {
            ViteManifest::clearCache();

            return vite()->asset($filename, $namespace);
        }

        $packageDir = trim(config("krayin-vite.viters.{$namespace}.package_assets_directory", 'src/Resources/assets'), '/');
        $key = $packageDir.'/'.ltrim($filename, '/');
        $chunk = $manifest['data'][$key] ?? null;

        if (! is_array($chunk) || empty($chunk['file'])) {
            ViteManifest::clearCache();

            return vite()->asset($filename, $namespace);
        }

        $buildDirectory = config("krayin-vite.viters.{$namespace}.build_directory", 'admin/build');

        return asset($buildDirectory.'/'.$chunk['file']).'?v='.$manifest['mtime'];
    }

    /**
     * @param  array<int, string>  $tags
     * @param  array<string, bool>  $emitted
     */
    private static function pushStylesheet(array &$tags, array &$emitted, string $url, int $version): void
    {
        $url = $url.'?v='.$version;

        if (isset($emitted[$url])) {
            return;
        }

        $tags[] = '<link rel="stylesheet" href="'.e($url).'" />';
        $emitted[$url] = true;
    }
}
