<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    protected $tableName;
    protected $keyColumn;
    protected $valueColumn;
    protected $autoloadColumn;
    protected $autoloadDefault;
    protected $defaultData;

    public function __construct()
    {
        $this->tableName        = Config::get('setting.database.table');
        $this->keyColumn        = Config::get('setting.key');
        $this->valueColumn      = Config::get('setting.value');
        $this->autoloadColumn   = Config::get('setting.autoload');
        $this->autoloadDefault  = (bool) Config::get('setting.autoload_default_value');
        $this->defaultData      = Config::get('setting.default_data');
    }

    public function up(): void
    {
        Schema::create($this->tableName, function(Blueprint $table)
        {
            $table->string($this->keyColumn)->primary();
            $table->longText($this->valueColumn)->nullable();

            if( isset($this->autoloadColumn) ) {
                $table->boolean($this->autoloadColumn)->default($this->autoloadDefault);
            }
        });

        if( is_array($this->defaultData ) && count($this->defaultData ) > 0 ) {
            foreach ($this->defaultData  as $data) {
                DB::table($this->tableName)->upsert([
                    $this->keyColumn        => $data['key'],
                    $this->valueColumn      => $data['value']?? NULL,
                    $this->autoloadColumn   => (bool) ($data['autoload']?? $this->autoloadDefault),
                ], $this->keyColumn);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
}
