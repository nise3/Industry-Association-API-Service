<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFourIrResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('four_ir_resources', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('four_ir_initiative_id');
            $table->unsignedTinyInteger('is_developed_financial_proposal')->default(0)->comment("0 => No, 1 => Yes");
            $table->decimal('total_amount')->default(0);
            $table->string('file_path')->nullable();
            $table->string('comment')->nullable();
            $table->string('accessor_type', 100);
            $table->string('approve_by', 100);
            $table->unsignedInteger('accessor_id');
            $table->unsignedTinyInteger('row_status')->default(1)->comment('0 => inactive, 1 => active');
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('four_ir_resources');
    }
}



