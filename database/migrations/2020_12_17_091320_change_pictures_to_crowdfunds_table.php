<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePicturesToCrowdfundsTable extends Migration
{

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('crowdfunds', function (Blueprint $table) {
            $table->json('pictures')->change();
        });
        Schema::table('crowdfund_items', function (Blueprint $table) {
            $table->json('pictures')->change();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('crowdfunds', function (Blueprint $table) {
            //
        });
    }

}
