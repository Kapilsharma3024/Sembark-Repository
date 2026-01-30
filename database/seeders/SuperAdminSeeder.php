<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = 'Kapil Sharma';
        $user->email = 'kapilsharma@gmail.com';
        $user->password = Hash::make('superadmin@123');
        $user->role = 'superadmin';
        $user->company_id = null;
        $user->created_at = now();
        $user->updated_at = now();
        $user->save();
    }
}
