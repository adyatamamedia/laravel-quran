<?php

namespace Adyatama\Quran\Console;

use Illuminate\Console\Command;

class UpdateCommand extends Command
{
    protected $signature = 'quran:update 
                            {--views : Also overwrite published views with package defaults}
                            {--config : Also overwrite published config with package defaults}';

    protected $description = 'Update and republish all Quran package assets (CSS, JS, Fonts, Images)';

    public function handle(): int
    {
        $this->info('Updating Laravel Quran Package assets...');

        // 1. Force republish assets (CSS, JS, Fonts, Images)
        $this->comment('Republishing latest assets (CSS, JS, Fonts, Images)...');
        $this->call('vendor:publish', [
            '--tag' => 'quran-assets',
            '--force' => true,
        ]);

        // 2. Optionally republish views
        if ($this->option('views')) {
            $this->comment('Republishing latest views...');
            $this->call('vendor:publish', [
                '--tag' => 'quran-views',
                '--force' => true,
            ]);
        }

        // 3. Optionally republish config
        if ($this->option('config')) {
            $this->comment('Republishing configuration...');
            $this->call('vendor:publish', [
                '--tag' => 'quran-config',
                '--force' => true,
            ]);
        }

        // 4. Force clear application and view cache
        $this->comment('Clearing Quran cache and compiled views...');
        try {
            \Illuminate\Support\Facades\Cache::flush();
        } catch (\Throwable $e) {}
        
        $this->callSilent('cache:clear');
        $this->callSilent('view:clear');

        $this->newLine();
        $this->info('Laravel Quran package assets and cache have been successfully refreshed to v' . config('quran.version', '2.1.1') . '!');
        $this->line('<comment>Tip:</comment> To automatically update assets on every <info>composer update</info>, add this to your <info>composer.json</info>:');
        $this->line('  "scripts": {');
        $this->line('    "post-update-cmd": [');
        $this->line('      "@php artisan quran:update --ansi"');
        $this->line('    ]');
        $this->line('  }');

        return Command::SUCCESS;
    }
}
