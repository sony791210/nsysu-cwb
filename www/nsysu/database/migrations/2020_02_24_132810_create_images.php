<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('images', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->tinyInteger('position')->default(1)->comment('圖片位置; 預設:1');
            $table->string('folder',255)->nullable()->comment('資料夾名稱');
            $table->string('filename',255)->nullable()->comment('資料夾名稱');
            $table->string('ext',255)->nullable()->comment('資料夾名稱');
            $table->string('origin_name',255)->nullable()->comment('資料夾名稱');
            $table->integer('width')->nullable()->comment('寬');
            $table->integer('height')->nullable()->comment('寬');
            $table->integer('size')->nullable()->comment('檔案大小');
            $table->json('compressed_info')->nullable()->comment('壓縮檔案資訊 b:大圖;m:中圖;s:小圖 ex.{"compressed_size_tags":["b", "m", "s"]}, "compressed_size":[1920, 960, 480]');
            $table->integer('news_id')->nullable()->comment('檔案大小');
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
        Schema::dropIfExists('images');
    }
}
