<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrowdfundsTable extends Migration
{

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('crowdfunds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('title');
            $table->string('cover')->nullable();
            $table->string('description')->nullable();
            $table->string('content');
            $table->decimal('amount', 10, 2);
            $table->boolean('status');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crowdfunds');
    }

}
