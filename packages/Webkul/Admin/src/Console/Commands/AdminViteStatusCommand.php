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
        $appUrl = (string) config('app.url');
        if (str_contains($appUrl, '127.0.0.1') || str_contains($appUrl, 'localhost')) {
            $this->warn('APP_URL is set to a local address: '.$appUrl);
            $this->warn('Set APP_URL=https://crm.supportplusco.com in .env (admin assets use relative paths, but other URLs may break).');
        }

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
        if (! is_file($cssPath)) {
            $this->error('CSS file missing on disk: '.$cssPath);
            $this->error('Run: cd packages/Webkul/Admin && npm run build');

            return self::FAILURE;
        }

        $this->line('CSS exists: yes ('.number_format(filesize($cssPath) / 1024, 1).' KB)');

        $head = (string) file_get_contents($cssPath, false, null, 0, 32);
        if (str_starts_with(ltrim($head), '<')) {
            $this->error('CSS file contains HTML, not styles — rebuild required (cd packages/Webkul/Admin && npm run build).');

            return self::FAILURE;
        }

        $sample = ViteTags::admin([$cssKey, $jsKey]);
        $this->newLine();
        $this->line('Generated tags (relative URLs):');
        $this->line((string) $sample);

        $publicHtml = dirname(base_path()).'/public_html';
        if (is_dir($publicHtml) && realpath($publicHtml) !== realpath(public_path())) {
            $this->newLine();
            $this->warn('public_html exists separately from Laravel public/:');
            $this->line('  Laravel public: '.public_path());
            $this->line('  public_html:    '.$publicHtml);
            $this->warn('Ensure public_html points to src/public (symlink) or copy admin/build after npm run build.');
        }

        return self::SUCCESS;
    }
}
