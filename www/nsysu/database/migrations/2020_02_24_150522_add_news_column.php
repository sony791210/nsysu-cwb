<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('news', function (Blueprint $table) {
            $table->tinyInteger('images_id')->after('id')->nullable();
            $table->renameColumn('datetime', 'release_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('images_id');
            $table->renameColumn( 'release_time','datetime');
        });
    }
}
