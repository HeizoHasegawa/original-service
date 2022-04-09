<?php

use Illuminate\Database\Seeder;

class WorkspacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++) {
            $num = sprintf("%03d", $i);
            DB::table('workspaces')->insert([
                'workspace_name' => 'ワークスペースNo' . $num,
                'image' => 'workspace' . $num . "jpg",
                'comment' => 'ワークスペースNo' . $num . "の紹介文です。",
                'charge' => rand(20,50) * 100,
                'image' => 'workspace' . $num . "jpg",
                'start_weekday' => rand(6,10) . ':00',
                'end_weekday' => rand(18,22) . ':00',
                'start_weekend' => rand(6,10) . ':00',
                'end_weekend' => rand(18,22) . ':00',
                'address' => '〒100-0014 東京都千代田区永田町１丁目７−１',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);
        }
    }
}
