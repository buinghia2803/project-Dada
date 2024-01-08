<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetDadIdIsForeignKeyContractOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_offers', function (Blueprint $table) {
            $table->unsignedBigInteger('dad_id')->change();
            $table->foreign('dad_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_offers', function (Blueprint $table) {
            $table->dropForeign(['dad_id']);
        });
    }
}
