<?php

use Webberman\LaravelSetting\Models\Setting;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;

if ( ! function_exists('getOption')) {
    /**
     * @param $name
     * @param null $default
     *
     * @return mixed
     */
    function getOption($name, $default = null)
    {
        return app()['setting']->get($name, $default);
    }
}

if ( ! function_exists('setOption')) {
    /**
     * @param $name
     * @param $value
     *
     * @return mixed
     */
    function setOption($name, $value)
    {
        return resolve('setting')->set($name, $value);
    }
}

if ( ! function_exists('setOptions')) {
    /**
     * @param array $options
     */
    function setOptions(array $options)
    {
        foreach ($options as $name => $value) {
            setOption($name, $value);
        }
    }
}