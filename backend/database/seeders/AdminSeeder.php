<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
			'name' => 'Админ',
            'login' => 'admin',
            'password' => app('hash')->make('1234567'),
        ]);
    }
}
