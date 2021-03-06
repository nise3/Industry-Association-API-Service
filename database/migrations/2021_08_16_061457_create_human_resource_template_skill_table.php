<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHumanResourceTemplateSkillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('human_resource_template_skills', function (Blueprint $table) {
            $table->unsignedInteger('human_resource_template_id');
            $table->unsignedMediumInteger('skill_id');

            $table->foreign('human_resource_template_id', 'hrts_hu_res_tem_id')
                ->references('id')
                ->on('human_resource_templates')
                ->onDelete('cascade');


            $table->foreign('skill_id', 'hrts_skill_id')
                ->references('id')
                ->on('skills')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('human_resource_skill');
    }
}
