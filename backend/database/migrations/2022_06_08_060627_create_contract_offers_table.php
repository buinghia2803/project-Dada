<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_offers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dad_id');
            $table->bigInteger('artist_id')->nullable();
            $table->string('email')->nullable();
            $table->datetime('date_start');
            $table->datetime('date_end');
            $table->decimal('selling_price', 11, 5);
            $table->tinyInteger('dad_percent');
            $table->tinyInteger('artist_percent');
            $table->decimal('dad_price', 11, 5)->nullable();
            $table->decimal('artist_price', 11, 5)->nullable();
            $table->decimal('system_price', 11, 5)->nullable();
            $table->decimal('opensea_price', 11, 5)->nullable();
            $table->float('system_percent', 5, 3);
            $table->float('opensea_percent', 5, 3);
            $table->text('responsibility');
            $table->text('contact_info');
            $table->tinyInteger('status')->comment("0 = waiting for signing, 1 = is in effect, 2 = reject, 3 = sold, 4 = Contract expiration")->default(0);
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
        Schema::dropIfExists('contract_offers');
    }
}
