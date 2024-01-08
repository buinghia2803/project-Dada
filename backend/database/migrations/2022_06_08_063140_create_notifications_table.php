<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('action')->nullable()->comment("Action classification");
            $table->tinyInteger('type')->comment("1 = Send all dad, 2 = Send all artist, 3 = Send all system");
            $table->datetime('date_public');
            $table->tinyInteger('status')->nullable()->comment('0 = not send, 1 = sent');
//            $table->date('date_public');
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
        Schema::dropIfExists('notifications');
    }
}
