<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHandpickToCrowdfundTable extends Migration
{

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('crowdfunds', function (Blueprint $table) {
            $table->boolean('handpick')->after('company_id');
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
