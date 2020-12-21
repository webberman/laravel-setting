<?php

namespace Webberman\LaravelSetting;

use Illuminate\Support\Manager;
use Illuminate\Support\Facades\Config;
use Webberman\LaravelSetting\Contracts\SettingDriverInterface;
use Webberman\LaravelSetting\Drivers\DatabaseSettingDriver;

class SettingManager extends Manager
{
    public function getDefaultDriver(): string
    {
        return Config::get('setting.default_driver', 'database');
    }

    public function CreateDatabaseDriver(): SettingDriverInterface
    {
        return new DatabaseSettingDriver( app() );
    }

    public function setDefaultDriver($name)
    {
        Config::set(['setting.default_driver' => $name]);
    }
}
