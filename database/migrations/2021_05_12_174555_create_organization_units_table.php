<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 600);
            $table->string('title_en', 300)->nullable();
            $table->unsignedSmallInteger('employee_size')->default(0);

            $table->unsignedInteger('organization_id');
            $table->unsignedInteger('organization_unit_type_id');

            $table->unsignedMediumInteger('loc_division_id')->nullable()->index('org_unit_loc_division_id_inx');
            $table->unsignedMediumInteger('loc_district_id')->nullable()->index('org_unit_loc_district_id_inx');
            $table->unsignedMediumInteger('loc_upazila_id')->nullable()->index('org_unit_loc_upazila_id_inx');
            $table->string('location_latitude', 50)->nullable();
            $table->string('location_longitude', 50)->nullable();
            $table->text('google_map_src')->nullable();

            $table->string('address', 1200)->nullable();
            $table->string('address_en', 600)->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('email', 191)->nullable();
            $table->string('fax_no', 50)->nullable();

            $table->string('contact_person_name', 500)->nullable();
            $table->string('contact_person_name_en', 250)->nullable();
            $table->string('contact_person_mobile', 15)->nullable();
            $table->string('contact_person_email', 191)->nullable();
            $table->string('contact_person_designation', 600)->nullable();
            $table->string('contact_person_designation_en', 300)->nullable();

            $table->unsignedTinyInteger('row_status')
                ->default(1)->comment('0 => inactive, 1 => active');
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
        Schema::dropIfExists('organization_units');
    }
}
