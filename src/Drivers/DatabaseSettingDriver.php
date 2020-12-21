<?php

namespace Webberman\LaravelSetting\Drivers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Collection;
use Webberman\LaravelSetting\Contracts\SettingModelInterface;
use Webberman\LaravelSetting\Contracts\SettingDriverInterface;

class DatabaseSettingDriver implements SettingDriverInterface
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var string
     */
    private $table;

    /**
     * @var SettingModelInterface
     */
    private $model;

    /**
     * @var string
     */
    private $keyColumn;

    /**
     * @var string
     */
    private $valueColumn;

    /**
     * @var string
     */
    private $autoloadColumn;

    /**
     * @var string
     */
    private $autoloadDefaultValue;

    /**
     * The settings collection.
     *
     * @var Collection
     */
    protected $setting;

    public function __construct(Application $app)
    {
        $this->app   = $app;
        $this->table = $app['config']->get('setting.database.table');
        $this->model = $app[SettingModelInterface::class];

        $this->keyColumn   = $app['config']->get('setting.key');
        $this->valueColumn = $app['config']->get('setting.value');

        $this->autoloadColumn       = $app['config']->get('setting.autoload');
        $this->autoloadDefaultValue = $app['config']->get('setting.autoload_default_value');

        $this->loadSetting();
    }

    /**
     * Get a setting row.
     *
     * @param $key
     * @param $default
     *
     * @return mixed
     */
    public function row($key, $default = null)
    {
        return $this->setting->firstWhere($this->keyColumn, $key) ?: $default;
    }

    /**
     * Check if a key already exists.
     *
     * @param $key
     *
     * @return bool
     */
    public function has($key): bool
    {
        return (bool) $this->row($key);
    }

    /**
     * Get the given item.
     *
     * @param $key
     * @param null $default
     *
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        if( $row = $this->row($key) ) {
            return $row->value;
        }

        return $default;
    }

    public function getAll(): array
    {
        if( Schema::hasTable($this->table) && count(Schema::getColumnListing($this->table) ) ) {

            return $this->setting->keyBy($this->keyColumn)->transform( function($setting) {
                return $setting->{$this->valueColumn};
            })->toArray();
        }

        return [];
    }

    /**
     * @param $key
     * @param null $value
     * @param null $autoload
     *
     * @return SettingDriverInterface
     */
    public function add($key, $value = null, $autoload = null): SettingDriverInterface
    {
        return $this->set($key, $value, $autoload);
    }

    /**
     * Add new item to settings
     *
     * @param $key
     * @param null $value
     * @param bool $autoload
     *
     * @return SettingDriverInterface
     */
    public function set($key, $value = null, $autoload = null): SettingDriverInterface
    {
        //If array is passed
        if( (func_num_args() === 1) && is_array($settings = func_get_arg(0 ) ) ){
            foreach($settings as $key=>$value) {
                $this->set($key, $value);
            }
        }

        $this->model::updateOrCreate([$this->keyColumn => $key], [
            $this->keyColumn       => $key,
            $this->valueColumn     => is_array($value)? json_encode($value) : strip_tags($value, ['<br>', '<p>']),
            $this->autoloadColumn  => $autoload?? $this->autoloadDefaultValue,
        ]);

        $this->reloadSetting();

        return $this;
    }

    /**
     * Delete the given key from storage.
     *
     * @param $key
     *
     * @return $this
     */
    public function delete($key): SettingDriverInterface
    {
        if ( is_array($key) ) {
            foreach($key as $k) {
                $this->delete($k);
            }
        }  else {
            if ($setting = $this->row($key)) {
                $setting->delete();
                $this->reloadSetting();
            }
        }

        return $this;
    }

    /**
     * Fetch the settings collection.
     *
     * @return void
     */
    private function loadSetting()
    {
        if( ! $this->app['config']->get('setting.enable_cache') ) {
            $this->setting = $this->model->autoload(true)->get();
            return;
        }

        $expireSeconds = $this->app['config']->get('setting.cache_expires');

        $this->setting = Cache::remember( 'setting', Carbon::now()->addSeconds($expireSeconds), function () {
            return $this->model->autoload(true)->get();
        });
    }

    /**
     * Clear cache and reload setting
     */
    private function reloadSetting()
    {
        Cache::forget('setting');
        $this->loadSetting();
    }
}