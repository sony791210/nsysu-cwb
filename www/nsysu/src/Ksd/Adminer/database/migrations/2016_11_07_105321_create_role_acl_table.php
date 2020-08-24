<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleAclTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_acl', function(Blueprint $table) {
            $table->unsignedInteger('role_id')->comment('角色索引');
            $table->unsignedInteger('acl_id')->comment('權限索引');
            $table->timestamps();
        });

        Schema::table('role_acl', function(Blueprint $table) {
            $table->primary(['role_id', 'acl_id']);
            $table->foreign('role_id')
                ->references('id')->on('role')
                ->onDelete('cascade');
            $table->foreign('acl_id')
                ->references('id')->on('acl')
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
        Schema::drop('role_acl');
    }
}
