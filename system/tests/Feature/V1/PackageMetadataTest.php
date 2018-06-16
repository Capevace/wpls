<?php

namespace Tests\Feature\V1;

use App\Package;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PackageMetadataTest extends TestCase
{
	use RefreshDatabase;

	protected $package;

	public function setUp()
	{
		parent::setUp();

		$this->package = factory(Package::class)->create();
	}

    /**
     * Test if you can successfully retreive metadata for a given package.
     * @group packageMetadata
     * @return void
     */
    public function testGetPackageMetadataWithoutActivation()
    {
        Storage::fake('packages');

        $package = new Package;
        $package->slug = 'test-slug';
        // var_dump($package->storagePath());

    	// $validLicense = factory(License::class)->create([
    	// 	'package_id' => $this->package->id,
    	// 	'supported_until' => Carbon::tomorrow()
    	// ]);

    	// $response = $this->json('POST', '/api/v1/license/activate', [
    	// 	'license' => $validLicense->license_key,
    	// 	'slug'    => $this->package->slug,
    	// 	'site'    => 'somesite.com'
        // ]);

        // $response
        //     ->assertStatus(200)
        //     ->assertJsonMissing(['error'])
        //     ->assertJsonStructure([
        //         'activation_id',
        //         'message'
        //     ])
        //     ->assertJson(['activated' => true]);
    }
}
