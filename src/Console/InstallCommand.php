<?php

namespace Adyatama\Quran\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'quran:install {--force : Overwrite existing files}';
    protected $description = 'Install and publish all assets, configuration, and views for Laravel Quran package';

    public function handle(): int
    {
        $this->info('📖 Installing Laravel Quran Package...');

        $force = $this->option('force');

        $this->comment('Publishing configuration...');
        $this->callSilent('vendor:publish', [
            '--tag' => 'quran-config',
            '--force' => $force,
        ]);

        $this->comment('Publishing assets (CSS, JS, Fonts)...');
        $this->callSilent('vendor:publish', [
            '--tag' => 'quran-assets',
            '--force' => true,
        ]);

        $this->info('✨ Laravel Quran Package successfully installed!');
        $this->line('🌐 You can now access Al-Quran at: <info>' . url(config('quran.prefix', 'quran')) . '</info>');

        return Command::SUCCESS;
    }
}
