<?php

namespace Webberman\LaravelSetting\Traits;

use Illuminate\Support\Facades\Config;

trait SettingModelTrait
{
    public function scopeAutoload($query, $value = true)
    {
        return $query->where('autoload', $value);
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable(): string
    {
        return Config::get('setting.database.table');
    }

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName(): string
    {
        return Config::get('setting.key');
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType(): string
    {
        return 'string';
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * Get the fillable attributes for the model.
     *
     * @return array
     */
    public function getFillable(): array
    {
        return [
            Config::get('setting.key'),
            Config::get('setting.value'),
            Config::get('setting.autoload')
        ];
    }

    /**
     * Determine if the model uses timestamps.
     *
     * @return bool
     */
    public function usesTimestamps(): bool
    {
        return false;
    }
}