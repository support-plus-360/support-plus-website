<?php

namespace Webkul\Admin\Console\Commands;

use Illuminate\Console\Command;
use Webkul\Core\ViteManifest;
use Webkul\Core\ViteTags;

class AdminViteStatusCommand extends Command
{
    protected $signature = 'admin:vite-status';

    protected $description = 'Show admin Vite manifest path, age, and resolved asset URLs (for deploy debugging)';

    public function handle(): int
    {
        $manifest = ViteManifest::read('admin');

        if ($manifest === null) {
            $this->error('manifest.json not found. Run: cd packages/Webkul/Admin && npm run build');

            return self::FAILURE;
        }

        $this->info('Manifest: '.$manifest['path']);
        $this->info('Updated: '.date('Y-m-d H:i:s', $manifest['mtime']));

        $cssKey = 'src/Resources/assets/css/app.css';
        $jsKey = 'src/Resources/assets/js/app.js';

        $cssFile = $manifest['data'][$cssKey]['file'] ?? '(missing)';
        $jsFile = $manifest['data'][$jsKey]['file'] ?? '(missing)';

        $this->line('CSS entry: '.$cssFile);
        $this->line('JS entry: '.$jsFile);

        $cssPath = public_path('admin/build/'.$cssFile);
        $this->line('CSS exists: '.(is_file($cssPath) ? 'yes' : 'NO — rebuild required'));

        $sample = ViteTags::admin([$cssKey, $jsKey]);
        $this->newLine();
        $this->line('Generated tags:');
        $this->line((string) $sample);

        return self::SUCCESS;
    }
}
