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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(ServiceRateSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(CategorySeeder::class);

        $user= new User();
        $user->name="admin";
        $user->email="admin@example.com";
        $user->password=Hash::make("adminpass");
        $user->phone='0123456789';
        $user->role="เจ้าของร้าน";
        $user->realrole="employee";
        $user->save();

        $employee=new Employee();
        $employee->name="admin";
        $employee->email="admin@example.com";
        $employee->password=Hash::make("adminpass");
        $employee->role="เจ้าของร้าน";
        $employee->phone="0123456789";
        $employee->save();
        // $user->setRememberToken("1234567890");

    }
}
