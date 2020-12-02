<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrowdfundOrdersTable extends Migration
{

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('crowdfund_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('购买人');
            $table->unsignedBigInteger('store_id')->comment('所属店铺');
            $table->unsignedBigInteger('crowdfund_item_id');
            $table->string('state');
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crowdfund_orders');
    }

}
