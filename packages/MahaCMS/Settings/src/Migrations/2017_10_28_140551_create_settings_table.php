<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('setting_name');
            $table->text('setting_value');
            $table->timestamps();
        });

        DB::table('settings')->insert([
            ['setting_name' => 'appname', 'setting_value' => "MahaCMS"],
            ['setting_name' => 'appdesc', 'setting_value' => "Just another MahaCMS site"]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
