<?php

use Illuminate\Database\Seeder;

class FacilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('facilities')->insert([
            'facility_name' => '椅子',
            'logo' => 'fa-solid fa-chair',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('facilities')->insert([
            'facility_name' => '電源',
            'logo' => 'fa-solid fa-plug-circle-bolt',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('facilities')->insert([
            'facility_name' => 'モニタ',
            'logo' => 'fa-solid fa-desktop',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('facilities')->insert([
            'facility_name' => 'wi-fi',
            'logo' => 'fa-solid fa-wifi',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('facilities')->insert([
            'facility_name' => 'トイレ',
            'logo' => 'fa-solid fa-restroom',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('facilities')->insert([
            'facility_name' => '休憩所',
            'logo' => 'fa-solid fa-mug-hot',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
