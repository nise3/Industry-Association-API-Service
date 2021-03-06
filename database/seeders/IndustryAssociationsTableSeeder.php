<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class IndustryAssociationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('industry_associations')->truncate();

        DB::table('industry_associations')->insert(array(
            array(
                'id' => 1,
                'code' => 'INA000001',
                'trade_id' => 1,
                'title' => 'মেট্রোপলিটন চেম্বার অব কমার্স অ্যান্ড ইন্ড্রাস্ট্রি, ঢাকা',
                'title_en' => 'Metropolitan Chamber of Commerce & Industry, Dhaka (MCCI)',
                'loc_division_id' => 3,
                'loc_district_id' => 18,
                'loc_upazila_id' => NULL,
                'location_latitude' => 23.730008133458167,
                'location_longitude' => 90.41600351534076,
                'google_map_src' => "https://www.google.com/maps/place/Metropolitan+Chamber+of+Commerce+and+Industry,+Dhaka/@23.7290456,90.4159606,15z/data=!4m2!3m1!1s0x0:0x29be237f53cc431b?sa=X&ved=2ahUKEwiYn6r0x-D1AhUK7nMBHa-5DtgQ_BJ6BAgyEAU",
                'address' => 'Chamber Building (4th Floor), 122-124, Motijheel CA, Dhaka-1000, Bangladesh',
                'address_en' => 'Chamber Building (4th Floor), 122-124, Motijheel CA, Dhaka-1000, Bangladesh',
                'country' => 'BD',
                'phone_code' => '880',
                'mobile' => '01767111434',
                'email' => 'tasmidurrahman@gmail.com',
                'fax_no' => NULL,
                'trade_number' => '',
                'name_of_the_office_head' => 'Mr Motior',
                'name_of_the_office_head_en' => 'Mr Motior',
                'name_of_the_office_head_designation' => 'CEO',
                'name_of_the_office_head_designation_en' => 'CEO',
                'contact_person_name' => 'Mr Razzak',
                'contact_person_name_en' => 'Mr Razzak',
                'contact_person_mobile' => '01767111434',
                'contact_person_email' => 'tasmidurrahman@gmail.com',
                'contact_person_designation' => 'CEO',
                'contact_person_designation_en' => 'CEO',
                'logo' => NULL,
                'domain' => 'https://mccibd.org',
                'row_status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2022-01-18 16:30:08',
                'updated_at' => '2022-01-30 14:32:15',
                'deleted_at' => NULL,
            ),
            array(
                'id' => 2,
                'code' => 'INA000002',
                'trade_id' => 1,
                'title' => 'জাতীয় ক্ষুদ্র ও কুটির শিল্প সমিতি, বাংলাদেশ (নাসিব)',
                'title_en' => 'The National Association of Small and Cottage Industries of Bangladesh (NASCIB)',
                'loc_division_id' => 3,
                'loc_district_id' => 18,
                'loc_upazila_id' => NULL,
                'location_latitude' => '23.74587385871404',
                'location_longitude' => '90.41255926982203',
                'google_map_src' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14608.243557006685!2d90.4126242!3d23.745208!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb533daf0bb8721e0!2sNational%20Association%20of%20Small%20%26%20Cottage%20Industries%20of%20Bangladesh%20(NASCIB)!5e0!3m2!1sen!2sbd!4v1630730307758!5m2!1sen!2sbd',
                'address' => 'Mezbah Uddin Plaza (6th Floor),91, New Circular Road, Mouchak, Dhaka-1217',
                'address_en' => 'Mezbah Uddin Plaza (6th Floor),91, New Circular Road, Mouchak, Dhaka-1217',
                'country' => 'BD',
                'phone_code' => '880',
                'mobile' => '01790635943',
                'email' => 'asmmahmud@gmail.com',
                'fax_no' => NULL,
                'trade_number' => '1234',
                'name_of_the_office_head' => 'Abdur Razzak',
                'name_of_the_office_head_en' => 'Abdur Razzak',
                'name_of_the_office_head_designation' => 'CEO',
                'name_of_the_office_head_designation_en' => 'CEO',
                'contact_person_name' => 'ASM Mahmudul Hasan',
                'contact_person_name_en' => 'ASM Mahmudul Hasan',
                'contact_person_mobile' => '01790635943',
                'contact_person_email' => 'asmmahmud@gmail.com',
                'contact_person_designation' => 'Engineer',
                'contact_person_designation_en' => 'Engineer',
                'logo' => 'https://nascib.org.bd/wp-content/uploads/2021/09/home-banner-1png.png',
                'domain' => 'https://nascib.org.bd',
                'row_status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2022-01-18 16:33:57',
                'updated_at' => '2022-02-01 15:58:01',
                'deleted_at' => NULL,
            ),
            array(
                'id' => 3,
                'code' => 'INA000003',
                'trade_id' => 1,
                'title' => 'ক্ষুদ্র ও মাঝারি শিল্প ফাউন্ডেশন (এসএমইএফ)',
                'title_en' => 'Small & Medium Enterprise Foundation (SMEF)',
                'loc_division_id' => 3,
                'loc_district_id' => 18,
                'loc_upazila_id' => NULL,
                'location_latitude' => 23.777862179731507,
                'location_longitude' => 90.3757152306815,
                'google_map_src' => 'https://www.google.com/maps/place/SME+Foundation/@23.7769,90.3756294,15z/data=!4m2!3m1!1s0x0:0x950c32ea6c497d2d?sa=X&ved=2ahUKEwijm8OsyeD1AhXdxjgGHUlZAicQ_BJ6BAg0EAU',
                'address' => 'E-5, C/1West Agargaon, Sher-e-Bangla Nagar Administrative Area, Dhaka 1207',
                'address_en' => 'E-5, C/1West Agargaon, Sher-e-Bangla Nagar Administrative Area, Dhaka 1207',
                'country' => 'BD',
                'phone_code' => '880',
                'mobile' => '01733341665',
                'email' => 'contact@smef.gov.bd',
                'fax_no' => NULL,
                'trade_number' => '',
                'name_of_the_office_head' => 'ড. মোঃ মাসুদুর রহমান',
                'name_of_the_office_head_en' => 'Dr. Md. Masudur Rahman',
                'name_of_the_office_head_designation' => 'Chairman',
                'name_of_the_office_head_designation_en' => 'Chairman',
                'contact_person_name' => 'Abdur Razzak',
                'contact_person_name_en' => NULL,
                'contact_person_mobile' => '01733341665',
                'contact_person_email' => 'contact@smef.gov.bd',
                'contact_person_designation' => 'Chairman',
                'contact_person_designation_en' => "Chairman",
                'logo' => NULL,
                'domain' => "https://smef.gov.bd",
                'row_status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2022-01-30 15:44:08',
                'updated_at' => '2022-01-30 15:47:48',
                'deleted_at' => NULL,
            ),
        ));

        Schema::enableForeignKeyConstraints();

    }
}
