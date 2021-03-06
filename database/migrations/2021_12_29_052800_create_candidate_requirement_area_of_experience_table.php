<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateRequirementAreaOfExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_requirement_area_of_experience', function (Blueprint $table) {
            $table->string("job_id")->index('index_area_exp_job_id');
            $table->integer("candidate_requirement_id")->index('index_area_experience_can_req_id');
            $table->integer("area_of_experience_id")->index('index_can_area_exp_area_exp_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidate_requirement_area_of_experience');
    }
}
