<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Settings;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        Settings::create([
			'name' => 'currency',
            'description' => 'Валюта - доллар США',
            'value' => 'usd',
        ]);

        Settings::create([
            'name' => 'BTC',
            'description' => 'BTC кошелек',
            'value' => '1NEnSb3rcBgd9NmHJaqzw2MY1NBrm6ZsnY',
        ]);

        Settings::create([
            'name' => 'ETH',
            'description' => 'Эфириум кошелек',
            'value' => '0xd5E7c616FF0f987Bb73307Df4F7008ddBFce356e',
        ]);

        Settings::create([
            'name' => 'ETH_PASSPHRASE',
            'description' => '',
            'value' => '123456',
        ]);

    }
}
