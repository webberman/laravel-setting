<?php

namespace Webberman\LaravelSetting;

use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Webberman\LaravelSetting\Models\Setting;
use Webberman\LaravelSetting\Commands\AddCommand;
use Webberman\LaravelSetting\Commands\DeleteCommand;
use Webberman\LaravelSetting\Contracts\SettingModelInterface;

class SettingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/setting.php', 'setting');

        $this->app->bind(SettingModelInterface::class, Config::get('setting.database.model', Setting::class) );

        $this->app->singleton('setting', function ($app) {
            return new SettingManager($app);
        });

        $this->app->singleton('settings', function () {
            return $this->app['setting']->getAll();
        });
    }

    public function boot(Filesystem $file)
    {
        $this->commands([AddCommand::class, DeleteCommand::class]);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/setting.php' => config_path('setting.php'),
            ], 'setting-config');

            $this->publishes([
                __DIR__."/../database/migrations/create_settings_table.php" => $this->getMigration($file,'create_settings_table.php'),
            ], 'setting-migration');
        }
    }

    protected function getMigration(Filesystem $file, string $migrationNameSuffix): string
    {
        $migrationsPath = $this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR;

        return Collection::make($migrationsPath)
                ->flatMap(function ($path) use ($file, $migrationNameSuffix) {
                    return $file->glob($path.'*_'.$migrationNameSuffix);
                })
                ->push( $migrationsPath . date('Y_m_d_His') . '_' . $migrationNameSuffix )
                ->first();
    }
}
