<?php
use App\Models\Registration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RegistrationSeeder extends Seeder
{
    public function run()
    {
        Registration::create([
            'university_id' => '123',
            'last_name' => 'Ram',
            'first_name' => 'Sri',
            'dateofbirth' => '2000-01-01',
            'gender' => 'male',
            'email' => 'sriram@gamil.com',
            'password' => Hash::make('password123'),
        ]);
    }
}