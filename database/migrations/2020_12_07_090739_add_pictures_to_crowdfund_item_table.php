<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPicturesToCrowdfundItemTable extends Migration
{

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('crowdfund_items', function (Blueprint $table) {
            $table->string('pictures')->nullable()->comment('图片')->after('title');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('crowdfund_items', function (Blueprint $table) {
            //
        });
    }

}
