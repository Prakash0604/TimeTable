<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Testing extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $faker=Faker::create();
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $teacher_id=[1,2,3];
        foreach (range(1, 10) as $index) {
            DB::table('timetables')->insert([
                'teacher_id' => $faker->randomElement($teacher_id),
                'starting_date' => $faker->date(),
                'ending_date' => $faker->date(),
                'starting_time' => $faker->time(),
                'ending_time' => $faker->time(),
                'day_of_week' => $faker->randomElement($days),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
