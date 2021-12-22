<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->string('estimate_id')->primary();
            $table->string('no');
            $table->string('final_id');
            $table->string('company_name');
            $table->string('user_id',11)->index();
            $table->string('customer_id',11)->index();
            $table->string('project_id',11)->index()->nullable();
            $table->string('active_name');
            $table->string('total_price');
            $table->date('account_date')->nullable();
            $table->string('account_file')->nullable();
            $table->date('padding_date')->nullable();
            $table->string('padding_file')->nullable();
            $table->string('staus');
            $table->date('receipt_date')->nullable();
            $table->string('receipt_file')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estimates');
    }
}
