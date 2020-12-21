<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Settings Driver
    |--------------------------------------------------------------------------
    | Sets the default "driver" to be used by this package
    |
    | Supported: "database"
    */
    'default_driver' => 'database',

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    | Sets the default "driver" to be used by this package
    |
    | Supported: "database"
    */
    'enable_cache' => true,

    'cache_expires' => 60 * 60 * 24 * 30, // 1 month

    /*
    |--------------------------------------------------------------------------
    | Key Column Name
    |--------------------------------------------------------------------------
    | Sets the name of the key column
    */
    'key' => 'name',

    /*
    |--------------------------------------------------------------------------
    | Value Column Name
    |--------------------------------------------------------------------------
    | Sets the name of the value column
    */
    'value' => 'value',

    /*
    |--------------------------------------------------------------------------
    | Autoload Column Name
    |--------------------------------------------------------------------------
    | Sets the name of the autoload column
    */
    'autoload' => 'autoload',

    /*
    |--------------------------------------------------------------------------
    | Autoload Default Value
    |--------------------------------------------------------------------------
    | Sets the default value of the autoload column
    */
    'autoload_default_value' => true,

    /*
    |--------------------------------------------------------------------------
    | Database Table and Model names
    |--------------------------------------------------------------------------
    | 'table_name' sets the name to be used for the settings table
    | 'model_name' sets the Model to be used in manipulating the Settings table
    |
    | Used only when the driver is set to 'database'.
    */
    'database' => [
        'table' => 'settings',
        'model' => \Webberman\LaravelSetting\Models\Setting::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Data
    |--------------------------------------------------------------------------
    | default data to be loaded into the settings datastore
    */
    'default_data' => [
        [
            'key' => 'company_name',
            'value' => 'Company Name',
            'autoload' => true,
        ],
    ]
];