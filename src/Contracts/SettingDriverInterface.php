<?php

namespace Webberman\LaravelSetting\Contracts;

use Illuminate\Foundation\Application;

interface SettingDriverInterface
{
    /**
     * Create Settings instance.
     *
     * @param Application $app
     */
    public function __construct(Application $app);

    /**
     * Get a settings row.
     *
     * @param $key
     * @param $default
     *
     * @return mixed
     */
    public function row($key, $default);

    /**
     * Determine whether the key is already exists.
     *
     * @param $key
     *
     * @return bool
     */
    public function has($key): bool;

    /**
     * Get the given item.
     *
     * @param $key
     * @param $default
     *
     * @return mixed
     */
    public function get($key, $default);

    /**
     * Get all settings as array
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Add new item to settings
     *
     * @param $key
     * @param $value
     * @param $autoload
     *
     * @return $this
     */
    public function set($key, $value, $autoload): SettingDriverInterface;

    /**
     * Delete the given key from storage.
     *
     * @param $key
     *
     * @return $this
     */
    public function delete($key): SettingDriverInterface;
}