<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_role', function(Blueprint $table) {
            $table->unsignedInteger('employee_id')->comment('成員索引');
            $table->unsignedInteger('role_id')->comment('角色索引');
            $table->timestamps();
        });

        /*Schema::table('employee_role', function(Blueprint $table) {
            $table->primary(['employee_id', 'role_id']);
            $table->foreign('employee_id')
                ->references('id')->on('employees')
                ->onDelete('cascade');
            $table->foreign('role_id')
                ->references('id')->on('role')
                ->onDelete('cascade');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('employee_role');
    }
}
