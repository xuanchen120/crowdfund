<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrowdfundItemsTable extends Migration
{

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('crowdfund_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crowdfund_id')->index();
            $table->string('title');
            $table->boolean('type')->comment('类型：1正常 2无条件支持');
            $table->string('time')->comment('回报时间');
            $table->string('content')->comment('回报内容');
            $table->string('shipping')->comment('配送说明');
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(0)->comment('限制人数，0为不限制');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crowdfund_items');
    }

}
