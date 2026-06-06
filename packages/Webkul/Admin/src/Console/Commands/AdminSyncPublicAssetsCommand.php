<?php

namespace Webkul\Admin\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AdminSyncPublicAssetsCommand extends Command
{
    protected $signature = 'admin:sync-public-assets
                            {--target= : Override destination public_html path}
                            {--all : Sync entire Laravel public/ folder, not only admin/build}';

    protected $description = 'Copy built admin assets from Laravel public/ to Hostinger public_html/ (when they are separate folders)';

    public function handle(): int
    {
        $targetRoot = $this->option('target')
            ?: dirname(base_path()).'/public_html';

        if (! is_dir($targetRoot)) {
            $this->error('Destination not found: '.$targetRoot);
            $this->line('Pass --target=/path/to/public_html if your web root differs.');

            return self::FAILURE;
        }

        if (realpath($targetRoot) === realpath(public_path())) {
            $this->info('public_html already points to Laravel public/. Nothing to sync.');

            return self::SUCCESS;
        }

        $source = $this->option('all')
            ? public_path()
            : public_path('admin/build');

        $destination = $this->option('all')
            ? $targetRoot
            : rtrim($targetRoot, '/').'/admin/build';

        if (! is_dir($source)) {
            $this->error('Source not found: '.$source);
            $this->line('Run first: cd packages/Webkul/Admin && npm run build');

            return self::FAILURE;
        }

        if (! is_dir(dirname($destination))) {
            File::makeDirectory(dirname($destination), 0755, true);
        }

        File::ensureDirectoryExists($destination);
        File::copyDirectory($source, $destination);

        $this->info('Synced:');
        $this->line('  from: '.$source);
        $this->line('  to:   '.$destination);

        if (is_file($destination.'/manifest.json')) {
            $manifest = json_decode((string) file_get_contents($destination.'/manifest.json'), true) ?: [];
            $css = $manifest['src/Resources/assets/css/app.css']['file'] ?? '(missing)';
            $this->line('  manifest CSS: '.$css);
        }

        $this->newLine();
        $this->comment('Tip: for a permanent fix, symlink public_html → src/public instead of copying each deploy.');

        return self::SUCCESS;
    }
}
