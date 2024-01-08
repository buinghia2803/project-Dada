<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStructContractOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_offers', function (Blueprint $table) {
            $table->text('responsibility')->nullable()->change();
            $table->text('contact_info')->nullable()->change();
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
            $table->text('responsibility')->change();
            $table->text('contact_info')->change();
        });
    }
}
