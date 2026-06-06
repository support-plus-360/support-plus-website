<?php

namespace Webkul\Core;

use Illuminate\Foundation\Vite as BaseVite;

class ViteManifest
{
    /**
     * Clear Laravel's in-memory Vite manifest cache (persists in Octane/long-lived workers).
     */
    public static function clearCache(): void
    {
        $ref = new \ReflectionClass(BaseVite::class);

        if (! $ref->hasProperty('manifests')) {
            return;
        }

        $property = $ref->getProperty('manifests');
        $property->setAccessible(true);
        $property->setValue(null, []);
    }

    /**
     * Read admin (or other) Vite manifest fresh from disk.
     *
     * @return array{path: string, mtime: int, data: array<string, mixed>}|null
     */
    public static function read(string $namespace = 'admin'): ?array
    {
        $config = config("krayin-vite.viters.{$namespace}");

        if (empty($config['build_directory'])) {
            return null;
        }

        $path = public_path($config['build_directory'].'/manifest.json');

        if (! is_file($path)) {
            return null;
        }

        $data = json_decode((string) file_get_contents($path), true);

        if (! is_array($data)) {
            return null;
        }

        return [
            'path'  => $path,
            'mtime' => (int) filemtime($path),
            'data'  => $data,
        ];
    }
}
