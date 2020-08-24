<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAclTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acl', function(Blueprint $table) {
            $table->increments('id')->comment('索引');
            $table->string('name')->unique()->comment('名稱');
            $table->text('description')->nullable()->comment('描述');
            $table->timestamps();
        });

        Schema::table('acl', function(Blueprint $table) {
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acl');
    }
}
