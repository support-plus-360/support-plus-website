<?php

namespace Webkul\Core;

use Illuminate\Support\Facades\Vite as BaseVite;
use Webkul\Core\Exceptions\ViterNotFound;

class Vite
{
    /**
     * Return the asset URL.
     */
    public function asset(string $filename, string $namespace = 'admin'): string
    {
        if ($namespace === 'admin') {
            return ViteTags::adminAsset($filename, $namespace);
        }

        $viters = config('krayin-vite.viters');

        if (empty($viters[$namespace])) {
            throw new ViterNotFound($namespace);
        }

        ViteManifest::clearCache();

        $url = trim($filename, '/');
        $viteUrl = trim($viters[$namespace]['package_assets_directory'], '/').'/'.$url;

        return BaseVite::useHotFile($viters[$namespace]['hot_file'])
            ->useBuildDirectory($viters[$namespace]['build_directory'])
            ->asset($viteUrl);
    }

    /**
     * Set krayin vite.
     *
     * @return mixed
     */
    public function set(mixed $entryPoints, string $namespace = 'admin')
    {
        $entryPoints = is_array($entryPoints) ? $entryPoints : [$entryPoints];

        if ($namespace === 'admin') {
            return ViteTags::admin($entryPoints);
        }

        $viters = config('krayin-vite.viters');

        if (empty($viters[$namespace])) {
            throw new ViterNotFound($namespace);
        }

        ViteManifest::clearCache();

        return BaseVite::useHotFile($viters[$namespace]['hot_file'])
            ->useBuildDirectory($viters[$namespace]['build_directory'])
            ->withEntryPoints($entryPoints);
    }
}
