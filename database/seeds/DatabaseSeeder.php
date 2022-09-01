<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // 追加分
            VueCrudDataBkTableSeeder::class,
        ]);
        $this->call(MessagesTableSeeder::class);
    }
}