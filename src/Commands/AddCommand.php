<?php

namespace Webberman\LaravelSetting\Commands;

use Illuminate\Console\Command;

class AddCommand extends Command
{
    protected $signature = 'setting:add';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //
    }
}
