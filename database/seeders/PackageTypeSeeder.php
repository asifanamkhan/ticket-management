<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Repositories\PackageType;

class PackageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packageTypes = [
            ['name' => 'Standard'],
            ['name' => 'Family'],
            ['name' => 'VIP'],
        ];

        foreach ($packageTypes as $packageType) {
            PackageType::save([
                'name' => $packageType['name']
            ]);
        }
    }
}
