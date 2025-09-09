<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Super Admin', 'user_id' => 'A001', 'email'=>'superadmin@admin.com', 'role' =>'Super Admin', 'password'=>bcrypt(12345678) ,'is_active'=>true]
        ];

        foreach($data as $item){
            User::create($item);
        }
    }
}
