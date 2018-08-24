<?php namespace TinTrang\Tuser\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTintrangTuser extends Migration
{
    public function up()
    {
        Schema::table('tintrang_tuser_', function($table)
        {
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('tintrang_tuser_', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
            $table->increments('id')->unsigned()->change();
        });
    }
}
