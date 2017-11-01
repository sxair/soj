<?php

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // if use model-factories while faster
        // but I lazy to create model
        for($i=0;$i<100;$i++) {
            DB::table('oj_problems')->insert([
                'problem_id' => $i+1,
                'title' => str_random(10),
            ]);
            DB::table('admin_problems')->insert([
                'problem_id' => $i+1,
                'title' => str_random(10),
                'user_name' => 'admin',
                'public' => rand(0, 1),
                'show' =>rand(0, 1)
            ]);
        }
    }
}
