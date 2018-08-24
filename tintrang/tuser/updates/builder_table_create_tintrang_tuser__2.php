<?php namespace TinTrang\Tuser\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTintrangTuser2 extends Migration
{
    public function up()
    {
        Schema::create('tintrang_tuser_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 50);
            $table->string('surname', 50);
            $table->string('email', 100);
            $table->string('phone', 20);
            $table->string('password', 40);
            $table->string('status', 20);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tintrang_tuser_');
    }
}
