<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('contract_offer_id');
            $table->bigInteger('contract_nft_id');
            $table->decimal('dad_price', 11, 5);
            $table->decimal('artist_price', 11, 5);
            $table->tinyInteger('status')->comment("0 = Wait for pay, 1 = paid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_payments');
    }
}
