<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('employee_id');
            $table->string('email')->nullable();
            $table->string('name', 20)->comment('登入帳號')->unique();
            $table->string('password', 72)->comment('密碼');
            $table->string('displayName', 20)->comment('姓名');
            $table->string('personal_code', 10)->comment('使用者代表碼');
            $table->tinyInteger('status')->default(1)->comment('狀態');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
