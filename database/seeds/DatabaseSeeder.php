<?php

use Illuminate\Database\Seeder;
use \Carbon\Carbon;
use \App\User;
use \App\Models\Stats;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'name' => 'Admin',
            'email' => 'admin@admin.ru',
            'password' => Hash::make('123456'),
            'isAdmin' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $datas = [
            ['name' => 'Яндекс', 'alias' => 'Yandex'],
            ['name' => 'Яндекс.Директ', 'alias' => 'Yandex: Direct'],
            ['name' => 'Новые посетитиели', 'alias' => 'yandex_search'],
            ['name' => 'Остальной трафик', 'alias' => 'other'],
            ['name' => 'Nadavi', 'alias' => 'nadavi'],
        ];

        foreach ($datas as $data) {
            Stats::insert([
                'name' => $data['name'],
                'alias' => $data['alias'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
