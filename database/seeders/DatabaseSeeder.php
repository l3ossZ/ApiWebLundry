<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LaundrySeeder::class);
        $this->call(ServiceRateSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(EmployeeSeeder::class);

//        $this->call(AddressSeeder::class);
//        $this->call(OrderSeeder::class);
        $this->call(CustomerSeeder::class);
    }
}
