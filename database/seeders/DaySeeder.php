<?php

namespace Database\Seeders;

use App\Repositories\Day;
use Illuminate\Database\Seeder;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = [
            ['code' => 'SAT', 'name' => 'Saturday'],
            ['code' => 'SUN', 'name' => 'Sunday'],
            ['code' => 'MON', 'name' => 'Monday'],
            ['code' => 'TUE', 'name' => 'Tuesday'],
            ['code' => 'WED', 'name' => 'Wednesday'],
            ['code' => 'THU', 'name' => 'Thursday'],
            ['code' => 'FRI', 'name' => 'Friday'],
        ];

        foreach ($days as $day) {
            Day::save([
                'name' => $day['name'],
                'code' => $day['code'],
            ]);
        }
    }
}
