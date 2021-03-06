<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EducationalInstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('educational_institutions')->truncate();

        $universities = [
            array('id' => '1', 'name' => 'University of Dhaka', 'name_en' => 'University of Dhaka', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '2', 'name' => 'University of Rajshahi', 'name_en' => 'University of Rajshahi', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '3', 'name' => 'Bangladesh Agricultural University', 'name_en' => 'Bangladesh Agricultural University', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '4', 'name' => 'Bangladesh University of Engineering & Technology', 'name_en' => 'Bangladesh University of Engineering & Technology', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '5', 'name' => 'University of Chittagong', 'name_en' => 'University of Chittagong', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '6', 'name' => 'Jahangirnagar University', 'name_en' => 'Jahangirnagar University', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '7', 'name' => 'Islamic University, Bangladesh', 'name_en' => 'Islamic University, Bangladesh', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '8', 'name' => 'Shahjalal University of Science and Technology', 'name_en' => 'Shahjalal University of Science and Technology', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '9', 'name' => 'Khulna University', 'name_en' => 'Khulna University', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '10', 'name' => 'Bangabandhu Sheikh Mujib Medical University ', 'name_en' => 'Bangabandhu Sheikh Mujib Medical University ', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '11', 'name' => 'Bangabandhu Sheikh Mujibur Rahman Agricultural University', 'name_en' => 'Bangabandhu Sheikh Mujibur Rahman Agricultural University', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '12', 'name' => 'Hajee Mohammad Danesh Science & Technology University', 'name_en' => 'Hajee Mohammad Danesh Science & Technology University', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '13', 'name' => 'Mawlana Bhashani Science and Technology University', 'name_en' => 'Mawlana Bhashani Science and Technology University', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '14', 'name' => 'Patuakhali Science and Technology University', 'name_en' => 'Patuakhali Science and Technology University', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '15', 'name' => 'Sher-e-Bangla Agricultural University', 'name_en' => 'Sher-e-Bangla Agricultural University', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '16', 'name' => 'Dhaka University of Engineering & Technology', 'name_en' => 'Dhaka University of Engineering & Technology', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '17', 'name' => 'Rajshahi University of Engineering & Technology', 'name_en' => 'Rajshahi University of Engineering & Technology', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '18', 'name' => 'Chittagong University of Engineering & Technology', 'name_en' => 'Chittagong University of Engineering & Technology', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '19', 'name' => 'Khulna University of Engineering & Technology', 'name_en' => 'Khulna University of Engineering & Technology', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '20', 'name' => 'Jagannath University', 'name_en' => 'Jagannath University', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '21', 'name' => 'Jatiya Kabi Kazi Nazrul Islam University', 'name_en' => 'Jatiya Kabi Kazi Nazrul Islam University', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '22', 'name' => 'Chittagong Veterinary and Animal Sciences University', 'name_en' => 'Chittagong Veterinary and Animal Sciences University', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '23', 'name' => 'Sylhet Agricultural University', 'name_en' => 'Sylhet Agricultural University', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '24', 'name' => 'Comilla University', 'name_en' => 'Comilla University', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '25', 'name' => 'Noakhali Science and Technology University', 'name_en' => 'Noakhali Science and Technology University', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '26', 'name' => 'Jessore University of Science & Technology', 'name_en' => 'Jessore University of Science & Technology', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '27', 'name' => 'Pabna University of Science and Technology', 'name_en' => 'Pabna University of Science and Technology', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '28', 'name' => 'Bangladesh University of Professionals', 'name_en' => 'Bangladesh University of Professionals', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '29', 'name' => 'Begum Rokeya University', 'name_en' => 'Begum Rokeya University', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '30', 'name' => 'Bangladesh University of Textiles', 'name_en' => 'Bangladesh University of Textiles', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '31', 'name' => 'University of Barisal', 'name_en' => 'University of Barisal', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '32', 'name' => 'Bangabandhu Sheikh Mujibur Rahman Science and Technology University', 'name_en' => 'Bangabandhu Sheikh Mujibur Rahman Science and Technology University', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '33', 'name' => 'Islamic Arabic University', 'name_en' => 'Islamic Arabic University', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '34', 'name' => 'Bangabandhu Sheikh Mujibur Rahman Maritime University', 'name_en' => 'Bangabandhu Sheikh Mujibur Rahman Maritime University', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '35', 'name' => 'Rangamati Science and Technology University', 'name_en' => 'Rangamati Science and Technology University', 'type' => 'Public', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '36', 'name' => 'Dhaka International University', 'name_en' => 'Dhaka International University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '37', 'name' => 'Ahsanullah University of Science and Technology', 'name_en' => 'Ahsanullah University of Science and Technology', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '38', 'name' => 'BRAC University', 'name_en' => 'BRAC University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '39', 'name' => 'East West University', 'name_en' => 'East West University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '40', 'name' => 'North South University', 'name_en' => 'North South University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '41', 'name' => 'American International University-Bangladesh', 'name_en' => 'American International University-Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '42', 'name' => 'Independent University, Bangladesh', 'name_en' => 'Independent University, Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '43', 'name' => 'Bangladesh University of Business and Technology', 'name_en' => 'Bangladesh University of Business and Technology', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '44', 'name' => 'Gono Bishwabidyalay', 'name_en' => 'Gono Bishwabidyalay', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '45', 'name' => 'Hamdard University Bangladesh', 'name_en' => 'Hamdard University Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '46', 'name' => 'International Islamic University, Chittagong', 'name_en' => 'International Islamic University, Chittagong', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '47', 'name' => 'Chittagong Independent University (CIU)', 'name_en' => 'Chittagong Independent University (CIU)', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '48', 'name' => 'University of Science & Technology Chittagong', 'name_en' => 'University of Science & Technology Chittagong', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '49', 'name' => 'BGC Trust University Bangladesh, Chittagong', 'name_en' => 'BGC Trust University Bangladesh, Chittagong', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '50', 'name' => 'East Delta University', 'name_en' => 'East Delta University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '51', 'name' => 'Bangladesh Army University of Science and Technology', 'name_en' => 'Bangladesh Army University of Science and Technology', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '52', 'name' => 'Bangladesh Army International University of Science & Technology', 'name_en' => 'Bangladesh Army International University of Science & Technology', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '53', 'name' => 'Britannia University', 'name_en' => 'Britannia University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '54', 'name' => 'Feni University', 'name_en' => 'Feni University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '55', 'name' => 'Bangladesh Army University of Engineering & Technology', 'name_en' => 'Bangladesh Army University of Engineering & Technology', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '56', 'name' => 'Premier University, Chittagong', 'name_en' => 'Premier University, Chittagong', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '57', 'name' => 'Exim Bank Agricultural University Bangladesh', 'name_en' => 'Exim Bank Agricultural University Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '58', 'name' => 'Southern University, Bangladesh', 'name_en' => 'Southern University, Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '59', 'name' => 'Port City International University', 'name_en' => 'Port City International University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '60', 'name' => 'Coxs Bazar International University', 'name_en' => 'Coxs Bazar International University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '61', 'name' => 'Notre Dame University Bangladesh', 'name_en' => 'Notre Dame University Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '62', 'name' => 'Asian University of Bangladesh', 'name_en' => 'Asian University of Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '63', 'name' => 'Asa University Bangladesh', 'name_en' => 'Asa University Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '64', 'name' => 'Atish Dipankar University of Science and Technology', 'name_en' => 'Atish Dipankar University of Science and Technology', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '65', 'name' => 'Bangladesh Islami University', 'name_en' => 'Bangladesh Islami University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '66', 'name' => 'Bangladesh University', 'name_en' => 'Bangladesh University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '67', 'name' => 'Central Women\'s University', 'name_en' => 'Central Women\'s University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '68', 'name' => 'City University, Bangladesh', 'name_en' => 'City University, Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '69', 'name' => 'Daffodil International University', 'name_en' => 'Daffodil International University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '70', 'name' => 'Eastern University, Bangladesh', 'name_en' => 'Eastern University, Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '71', 'name' => 'Green University of Bangladesh', 'name_en' => 'Green University of Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '72', 'name' => 'IBAIS University', 'name_en' => 'IBAIS University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '73', 'name' => 'Sonargaon University', 'name_en' => 'Sonargaon University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '74', 'name' => 'International University of Business Agriculture and Technology', 'name_en' => 'International University of Business Agriculture and Technology', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '75', 'name' => 'Manarat International University', 'name_en' => 'Manarat International University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '76', 'name' => 'Millennium University', 'name_en' => 'Millennium University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '77', 'name' => 'Northern University, Bangladesh', 'name_en' => 'Northern University, Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '78', 'name' => 'North Western University, Bangladesh', 'name_en' => 'North Western University, Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '79', 'name' => 'People\'s University of Bangladesh', 'name_en' => 'People\'s University of Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '80', 'name' => 'Presidency University', 'name_en' => 'Presidency University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '81', 'name' => 'Pundra University of Science and Technology', 'name_en' => 'Pundra University of Science and Technology', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '82', 'name' => 'Prime University', 'name_en' => 'Prime University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '83', 'name' => 'European University of Bangladesh', 'name_en' => 'European University of Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '84', 'name' => 'Primeasia University', 'name_en' => 'Primeasia University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '85', 'name' => 'Queens University', 'name_en' => 'Queens University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '86', 'name' => 'Rajshahi Science & Technology University', 'name_en' => 'Rajshahi Science & Technology University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '87', 'name' => 'Royal University of Dhaka', 'name_en' => 'Royal University of Dhaka', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '88', 'name' => 'Shanto-Mariam University of Creative Technology', 'name_en' => 'Shanto-Mariam University of Creative Technology', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '89', 'name' => 'Southeast University', 'name_en' => 'Southeast University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '90', 'name' => 'Stamford University Bangladesh', 'name_en' => 'Stamford University Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '91', 'name' => 'State University of Bangladesh', 'name_en' => 'State University of Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '92', 'name' => 'United International University', 'name_en' => 'United International University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '93', 'name' => 'University of Asia Pacific (Bangladesh)', 'name_en' => 'University of Asia Pacific (Bangladesh)', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '94', 'name' => 'University of Development Alternative', 'name_en' => 'University of Development Alternative', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '95', 'name' => 'University of Information Technology and Sciences', 'name_en' => 'University of Information Technology and Sciences', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '96', 'name' => 'University of Liberal Arts Bangladesh', 'name_en' => 'University of Liberal Arts Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '97', 'name' => 'Fareast International University', 'name_en' => 'Fareast International University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '98', 'name' => 'University of South Asia, Bangladesh', 'name_en' => 'University of South Asia, Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '99', 'name' => 'Uttara University', 'name_en' => 'Uttara University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '100', 'name' => 'Victoria University of Bangladesh', 'name_en' => 'Victoria University of Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '101', 'name' => 'Varendra University', 'name_en' => 'Varendra University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '102', 'name' => 'World University of Bangladesh', 'name_en' => 'World University of Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '103', 'name' => 'Leading University', 'name_en' => 'Leading University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '104', 'name' => 'Metropolitan University', 'name_en' => 'Metropolitan University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '105', 'name' => 'North East University Bangladesh', 'name_en' => 'North East University Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '106', 'name' => 'Sylhet International University', 'name_en' => 'Sylhet International University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '107', 'name' => 'Khwaja Yunus Ali University', 'name_en' => 'Khwaja Yunus Ali University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '108', 'name' => 'Global University Bangladesh', 'name_en' => 'Global University Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '109', 'name' => 'University of Creative Technology Chittagong', 'name_en' => 'University of Creative Technology Chittagong', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '110', 'name' => 'Z H Sikder University of Science & Technology', 'name_en' => 'Z H Sikder University of Science & Technology', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '111', 'name' => 'Central University of Science and Technology', 'name_en' => 'Central University of Science and Technology', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '112', 'name' => 'Canadian University of Bangladesh', 'name_en' => 'Canadian University of Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '113', 'name' => 'First Capital University of Bangladesh', 'name_en' => 'First Capital University of Bangladesh', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '114', 'name' => 'Ishaka International University', 'name_en' => 'Ishaka International University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '115', 'name' => 'Northern University of Business & Technology, Khulna', 'name_en' => 'Northern University of Business & Technology, Khulna', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '116', 'name' => 'North Bengal International University', 'name_en' => 'North Bengal International University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '117', 'name' => 'Ranada Prasad Shaha University', 'name_en' => 'Ranada Prasad Shaha University', 'type' => 'Private', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '118', 'name' => 'Islamic University of Technology', 'name_en' => 'Islamic University of Technology', 'type' => 'International', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '119', 'name' => 'Asian University for Women', 'name_en' => 'Asian University for Women', 'type' => 'International', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '120', 'name' => 'Bangladesh Open University', 'name_en' => 'Bangladesh Open University', 'type' => 'Special', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '121', 'name' => 'National University of Bangladesh', 'name_en' => 'National University of Bangladesh', 'type' => 'Special', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '122', 'name' => 'Islamic Arabic University', 'name_en' => 'Islamic Arabic University', 'type' => 'Special', 'deleted_at' => NULL, 'created_at' => NULL, 'updated_at' => NULL)
        ];

        DB::table('educational_institutions')->insert($universities);

        Schema::enableForeignKeyConstraints();
    }
}
