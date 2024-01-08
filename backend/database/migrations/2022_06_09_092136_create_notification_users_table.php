<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('notification_id');
            $table->bigInteger('admin_id')->comment("If is admin create message system")->default(0);
            $table->bigInteger('user_form')->comment("user_id: User sends");
            $table->bigInteger('user_to')->comment("user_id: User receives");
            $table->tinyInteger('status')->comment('0 = not seen, 1 = Watched');
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
        Schema::dropIfExists('notification_users');
    }
}
