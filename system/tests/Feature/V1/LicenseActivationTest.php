<?php

namespace Tests\Feature\V1;

use App\License;
use App\Package;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Carbon\Carbon;

class LicenseActivationTest extends TestCase
{
	use RefreshDatabase;

	protected $package;

	public function setUp()
	{
		parent::setUp();

		$this->package = factory(Package::class)->create();
	}

    /**
     * Test if a valid license will be activated successfully.
     * @group activation
     * @return void
     */
    public function testActivateValidLicense()
    {
    	$validLicense = factory(License::class)->create([
    		'package_id' => $this->package->id,
    		'supported_until' => Carbon::tomorrow()
    	]);

    	$response = $this->json('POST', '/api/v1/license/activate', [
    		'license' => $validLicense->license_key,
    		'slug'    => $this->package->slug,
    		'site'    => 'somesite.com'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonMissing(['error'])
            ->assertJsonStructure([
                'activation_id',
                'message'
            ])
            ->assertJson(['activated' => true]);
    }

    /**
     * Test if a valid license will be activated successfully.
     *
     * @group activation
     * @return void
     */
    public function testActivateValidEnvatoPurchaseCode()
    {
        $envatoPackage = factory(Package::class)->create([
            'envato_item_id' => env('ENVATO_TEST_ITEM_ID')
        ]);
        $purchaseCode = env('ENVATO_TEST_PURCHASE_CODE');

        $response = $this->json('POST', '/api/v1/license/activate', [
            'license' => $purchaseCode,
            'slug'    => $envatoPackage->slug,
            'site'    => 'somesite.com'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonMissing(['error'])
            ->assertJsonStructure([
                'activation_id',
                'message'
            ])
            ->assertJson(['activated' => true]);
    }

    /**
     * Test if a valid license will not be activated, if the license expired.
     *
     * @group activation
     * @return void
     */
    public function testActivateExpiredLicense()
    {
        $expiredLicense = factory(License::class)->create([
            'package_id' => $this->package->id,
            'supported_until' => Carbon::yesterday()
        ]);

        $response = $this->json('POST', '/api/v1/license/activate', [
            'license' => $expiredLicense->license_key,
            'slug'    => $this->package->slug,
            'site'    => 'somesite.com'
        ]);

        $response
            ->assertStatus(403)
            ->assertJsonMissing(['activated', 'activation'])
            ->assertJsonStructure(['error'])
            ->assertJson([
                'message' => 'The support period for the supplied license has ended.'
            ]);
    }

    /**
     * Test if an ivalid license will not be activated.
     *
     * @group activation
     * @return void
     */
    public function testActivateInvalidLicense()
    {   
        $response = $this->json('POST', '/api/v1/license/activate', [
            'license' => 'invalid-license',
            'slug'    => $this->package->slug,
            'site'    => 'somesite.com'
        ]);

        $response
            ->assertStatus(403)
            ->assertJsonMissing(['activated', 'activation'])
            ->assertJsonStructure(['error'])
            ->assertJson([
                'message' => 'The supplied license is invalid.'
            ]);
    }

    /**
     * Test if a valid and invalid license will not be activated due to an unknown package.
     *
     * @group activation
     * @return void
     */
    public function testActivateValidLicenseWithUnknownPackage()
    {
        $validLicense = factory(License::class)->create([
            'package_id' => $this->package->id,
            'supported_until' => Carbon::tomorrow()
        ]);

        // Test with valid license
        $response = $this->json('POST', '/api/v1/license/activate', [
            'license' => $validLicense->license_key,
            'slug'    => 'unknown-package',
            'site'    => 'somesite.com'
        ]);

        $response
            ->assertStatus(404)
            ->assertJsonMissing(['activated', 'activation'])
            ->assertJsonStructure(['error'])
            ->assertJson([
                'message' => 'The theme/plugin with was not found.'
            ]);
    }

    /**
     * Test if an invalid license will not be activated due to an unknown package.
     *
     * @group activation
     * @return void
     */
    public function testActivateInvalidLicenseWithUnknownPackage()
    {
        $response = $this->json('POST', '/api/v1/license/activate', [
            'license' => 'random-invalid-license-key',
            'slug'    => 'unknown-package',
            'site'    => 'somesite.com'
        ]);

        $response
            ->assertStatus(404)
            ->assertJsonMissing(['activated', 'activation'])
            ->assertJsonStructure(['error'])
            ->assertJson([
                'message' => 'The theme/plugin with was not found.'
            ]);
    }

    /**
     * Test if a valid license thats been used already, sent from a different page, fails.
     * 
     * @group activation
     */
    public function testActivateOverusedLicense()
    {
        $validLicense = factory(License::class)->create([
            'package_id' => $this->package->id,
            'supported_until' => Carbon::tomorrow()
        ]);

        $response = $this->json('POST', '/api/v1/license/activate', [
            'license' => $validLicense->license_key,
            'slug'    => $this->package->slug,
            'site'    => 'somesite.com'
        ]);

        // License now activated
        $response
            ->assertStatus(200)
            ->assertJson([
                'activated' => true
            ]);

        // Activating License again from different site should lead to it being rejected
        $response2 = $this->json('POST', '/api/v1/license/activate', [
            'license' => $validLicense->license_key,
            'slug'    => $this->package->slug,
            'site'    => 'differentsite.com'
        ]);

        $response2
            ->assertStatus(403)
            ->assertJsonMissing(['activated', 'activation'])
            ->assertJsonStructure(['error'])
            ->assertJson([
                'message' => 'The limit for the amount of sites the theme/plugin can be enabled on has been reached.'
            ]);
    }

    /**
     * Test if a valid license thats been used already with that site, gets activated.
     * 
     * @group activation
     */
    public function testActivateOverusedLicenseSameSite()
    {
        $validLicense = factory(License::class)->create([
            'package_id' => $this->package->id,
            'supported_until' => Carbon::tomorrow()
        ]);

        $response = $this->json('POST', '/api/v1/license/activate', [
            'license' => $validLicense->license_key,
            'slug'    => $this->package->slug,
            'site'    => 'somesite.com'
        ]);

        // License now activated
        $response
            ->assertStatus(200)
            ->assertJson([
                'activated' => true
            ]);

        // Activating License again from same site should lead to it being accepted and 'activated' (in truth, just return that it already is activated)
        $response2 = $this->json('POST', '/api/v1/license/activate', [
            'license' => $validLicense->license_key,
            'slug'    => $this->package->slug,
            'site'    => 'somesite.com'
        ]);

        $response2
            ->assertStatus(200)
            ->assertJsonMissing(['error'])
            ->assertJsonStructure([
                'activation_id',
                'message'
            ])
            ->assertJson(['activated' => true]);
    }
}
