<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChannelOwnersToVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('owner')->nullable(false)->default('');
            $table->string('channel_id')->nullable(false)->default('');
            $table->dateTime('published_at')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videos', function(Blueprint $table) {
            $table->dropColumn('published_at');
            $table->dropColumn('channel_id');
            $table->dropColumn('owner');
        });
    }
}
