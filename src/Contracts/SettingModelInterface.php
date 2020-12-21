<?php

namespace Webberman\LaravelSetting\Contracts;

interface SettingModelInterface
{
    public function scopeAutoload($query, $value);
}