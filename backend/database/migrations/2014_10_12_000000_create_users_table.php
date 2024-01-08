<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('public_address_main')->unique();
            $table->string('public_address_sub')->nullable();
            $table->string('contract_address')->nullable();
            $table->string('email')->nullable();
            $table->string('full_name', 100);
            $table->string('image_url')->nullable();
            $table->string('positions', 100)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('type')->comment("1 = Dad, 2 = Artist")->default(1);
            $table->tinyInteger('status')->comment("0 = Not active, 1 = Active, 2 = Delete")->default(1);
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
        Schema::dropIfExists('users');
    }
}
