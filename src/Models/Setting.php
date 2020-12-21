<?php

namespace Webberman\LaravelSetting\Models;

use Illuminate\Database\Eloquent\Model;
use Webberman\LaravelSetting\Traits\SettingModelTrait;
use Webberman\LaravelSetting\Contracts\SettingModelInterface;

class Setting extends Model implements SettingModelInterface
{
    use SettingModelTrait;
}
