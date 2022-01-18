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
            
            $table->string('estimate_id',11)->primary();
            $table->string('no');
            $table->string('final_id');
            $table->string('company_name');
            $table->string('user_id')->index();
            $table->string('customer_id');
            $table->string('project_id')->index();
            $table->string('active_name');
            $table->string('total_price');
            $table->string('account_date');
            $table->string('account_file');
            $table->string('padding_date');
            $table->string('padding_file');
            $table->string('status');
            $table->string('receipt_date');
            $table->string('receipt_file');
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
