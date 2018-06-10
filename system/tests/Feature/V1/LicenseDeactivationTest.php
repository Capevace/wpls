<?php

namespace Tests\Feature\V1;

use App\License;
use App\Package;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Carbon\Carbon;

class LicenseDeactivationTest extends TestCase
{
	use RefreshDatabase;

	protected $package;

	public function setUp()
	{
		parent::setUp();

		$this->package = factory(Package::class)->create();
	}

    /**
     * Tests if deactivating an activated license will work.
     * 
     * @group deactivation
     */
    public function testDeactivateActivatedLicense()
    {
        $validLicense = factory(License::class)->create([
            'package_id' => $this->package->id,
            'supported_until' => Carbon::tomorrow()
        ]);

        $response = $this->json('POST', '/api/v1/activate', [
            'license' => $validLicense->license_key,
            'slug'    => $this->package->slug,
            'site'    => 'somesite.com'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['activated' => true]);

        $response2 = $this->json('POST', '/api/v1/deactivate', [
            'license' => $validLicense->license_key,
            'slug'    => $this->package->slug,
            'site'    => 'somesite.com'
        ]);

        $response2
            ->assertStatus(200)
            ->assertJsonMissing(['error'])
            ->assertJsonStructure([
                'message'
            ])
            ->assertJson(['deactivated' => true]);
    }

    /**
     * Tests if deactivating a valid license that hasn't been activated will fail.
     * 
     * @group deactivation
     */
    public function testDeactivateUnactivatedValidLicense()
    {
        $validLicense = factory(License::class)->create([
            'package_id' => $this->package->id,
            'supported_until' => Carbon::tomorrow()
        ]);

        $response = $this->json('POST', '/api/v1/deactivate', [
            'license' => $validLicense->license_key,
            'slug'    => $this->package->slug,
            'site'    => 'somesite.com'
        ]);

        $response
            ->assertStatus(404)
            ->assertJsonStructure(['message', 'error'])
            ->assertJsonMissing(['deactivated'])
            ->assertJson([
                'message' => 'The license you wanted to deactivate was never activated for that package or that site.'
            ]); 
    }

    /**
     * Tests if deactivating an invalid license that hasn't been activated will fail.
     * 
     * @group deactivation
     */
    public function testDeactivateUnactivatedInvalidLicense()
    {
        $response = $this->json('POST', '/api/v1/deactivate', [
            'license' => 'unknown-license',
            'slug'    => $this->package->slug,
            'site'    => 'somesite.com'
        ]);

        $response
            ->assertStatus(403)
            ->assertJsonStructure(['message', 'error'])
            ->assertJsonMissing(['deactivated'])
            ->assertJson([
                'message' => 'The supplied license is invalid.'
            ]); 
    }

    /**
     * Tests if deactivating an invalid license that hasn't been activated will fail.
     * 
     * @group deactivation
     */
    public function testDeactivateActivatedLicenseWithWrongSite()
    {
        $validLicense = factory(License::class)->create([
            'package_id' => $this->package->id,
            'supported_until' => Carbon::tomorrow()
        ]);

        $response = $this->json('POST', '/api/v1/activate', [
            'license' => $validLicense->license_key,
            'slug'    => $this->package->slug,
            'site'    => 'somesite.com'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['activated' => true]);

        $response2 = $this->json('POST', '/api/v1/deactivate', [
            'license' => $validLicense->license_key,
            'slug'    => $this->package->slug,
            'site'    => 'differentsite.com'
        ]);

        $response2
            ->assertStatus(404)
            ->assertJsonStructure(['message', 'error'])
            ->assertJsonMissing(['deactivated'])
            ->assertJson([
                'message' => 'The license you wanted to deactivate was never activated for that package or that site.'
            ]); 
    }

    /**
     * Tests if deactivating an activated license with the wrong package will fail.
     * 
     * @group deactivation
     */
    public function testDeactivateActivatedLicenseWithWrongPackage()
    {
        $validLicense = factory(License::class)->create([
            'package_id' => $this->package->id,
            'supported_until' => Carbon::tomorrow()
        ]);

        $response = $this->json('POST', '/api/v1/activate', [
            'license' => $validLicense->license_key,
            'slug'    => $this->package->slug,
            'site'    => 'somesite.com'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['activated' => true]);

        $response2 = $this->json('POST', '/api/v1/deactivate', [
            'license' => $validLicense->license_key,
            'slug'    => 'sluggish-package',
            'site'    => 'somesite.com'
        ]);

        $response2
            ->assertStatus(404)
            ->assertJsonStructure(['message', 'error'])
            ->assertJsonMissing(['deactivated'])
            ->assertJson([
                'message' => 'The theme/plugin with was not found.'
            ]); 
    }
}
