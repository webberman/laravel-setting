<?php

namespace Webberman\LaravelSetting;

use Illuminate\Support\Facades\Facade;

class SettingFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'setting';
    }
}
