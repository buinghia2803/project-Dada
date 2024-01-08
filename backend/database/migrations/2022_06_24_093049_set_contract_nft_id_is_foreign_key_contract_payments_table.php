<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetContractNftIdIsForeignKeyContractPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('contract_nft_id')->change();
            $table->foreign('contract_nft_id')->references('id')->on('contract_nfts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_payments', function (Blueprint $table) {
            $table->dropForeign(['contract_nft_id']);
        });
    }
}
