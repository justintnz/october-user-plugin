<?php namespace TinTrang\Tuser\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTintrangTuser extends Migration
{
    public function up()
    {
        Schema::create('tintrang_tuser_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('id');
            $table->string('email', 100);
            $table->string('name', 100);
            $table->string('password', 40);
            $table->string('status', 20)->default('unverified');
            $table->dateTime('create_date');
            $table->primary(['id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tintrang_tuser_');
    }
}
