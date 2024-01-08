<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_contracts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('contract_offer_id');
            $table->bigInteger('contract_nft_id');
            $table->bigInteger('dad_id');
            $table->bigInteger('artist_id');
            $table->text('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_contracts');
    }
}
