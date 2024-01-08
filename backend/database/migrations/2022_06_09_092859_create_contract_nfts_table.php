<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractNftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_nfts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('contract_offer_id');
            $table->string('name', 100);
            $table->string('image_url');
            $table->text('description');
            $table->string('token_url')->nullable();
            $table->string('address_contract')->nullable();
            $table->string('token_contract')->nullable();
            $table->float('gas_fee', 5, 3)->nullable();
            $table->tinyInteger('status')->comment("0 = wait for confirmation, 1 = approve, 2 = reject, 3 = approve opensea, 4 = reject opensea");
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
        Schema::dropIfExists('contract_nfts');
    }
}
