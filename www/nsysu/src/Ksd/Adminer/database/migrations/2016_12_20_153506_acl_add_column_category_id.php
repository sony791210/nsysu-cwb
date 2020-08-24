<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AclAddColumnCategoryId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acl_category', function(Blueprint $table) {
            $table->increments('id')->comment('索引');
            $table->string('name')->unique()->comment('名稱');
            $table->text('descrption')->nullable()->comment('描述');
            $table->timestamps();
        });
        Schema::table('acl', function(Blueprint $table) {
            $table->unsignedInteger('category_id')->after('id')->nullable()->comment('類別索引');
            $table->foreign('category_id')
                ->references('id')->on('acl_category')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acl', function(Blueprint $table) {
            $table->dropForeign('acl_category_id_foreign');
            $table->dropColumn('category_id');
        });
        Schema::drop('acl_category');
    }
}
