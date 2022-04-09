<?php

use Illuminate\Database\Seeder;

class Workspace_facilityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 21; $i <= 30; $i++) {
            $x = rand(1,6);
            while ($x <= 6){
                DB::table('workspace_facility')->insert([
                    'workspace_id' =>  $i,
                    'facility_id' => $x,
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                ]);
                $x += rand(1,3);
            }
        }
    }
}
