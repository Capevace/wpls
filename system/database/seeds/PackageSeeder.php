<?php

use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Package::class, 5)
        	->create()
        	->each(function ($package) {
        		factory(App\Models\License::class, 4)
        			->create()
        			->each(function ($license) use ($package) {
        				$license->package_id = $package->id;
        				$license->save();
        			});
            });
    }
}
