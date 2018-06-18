<?php

use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        var_dump($this->command->getOutput());
        // factory(App\Models\User::class, 1)
        	// ->create();
    }
}
