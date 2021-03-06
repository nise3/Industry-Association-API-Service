<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHumanResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('human_resources', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('organization_id');
            $table->unsignedInteger('organization_unit_id');
            $table->string('title', 600);
            $table->string('title_en', 300)->nullable();
            $table->unsignedInteger('parent_id')->nullable()
                ->comment('Self Parent Id');

            $table->unsignedInteger('rank_id')->nullable();
            $table->unsignedInteger('display_order')->default(0);
            $table->unsignedTinyInteger('is_designation')
                ->default(1)
                ->comment('1 => designation, 0 => wings or section');

            $table->unsignedTinyInteger('status')
                ->default(1)->comment('1 => occupied, 2 => vacancy, 0 => inactive');

            $table->unsignedTinyInteger('row_status')
                ->default(1)
                ->comment('0 => inactive, 1 => active');

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('human_resources');
    }
}
