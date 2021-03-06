<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTeamFilePathToFourIrInitiativeAnalysis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('four_ir_initiative_analysis', function (Blueprint $table) {
            $table->string('team_file_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('four_ir_initiative_analysis', function (Blueprint $table) {
            $table->dropColumn("team_file_path");
        });
    }
}
