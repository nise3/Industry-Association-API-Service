<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOrgUnitTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organization_unit_types', function (Blueprint $table) {
            $table->foreign('organization_id', 'org_organization_id_unit_type_fk')
                ->references('id')
                ->on('organizations')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organization_unit_types', function (Blueprint $table) {
            $table->dropForeign('org_organization_id_unit_type_fk');
        });
    }
}
