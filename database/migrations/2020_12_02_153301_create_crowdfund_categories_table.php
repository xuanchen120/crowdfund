<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrowdfundCategoriesTable extends Migration
{

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('crowdfund_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->index();
            $table->unsignedBigInteger('parent_id')->default(0)->index();
            $table->string('title');
            $table->string('remark');
            $table->string('cover')->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crowdfund_categories');
    }

}
