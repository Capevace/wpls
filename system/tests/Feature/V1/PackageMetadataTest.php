<?php

namespace Tests\Feature\V1;

use App\Package;
use App\License;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class PackageMetadataTest extends TestCase
{
	use RefreshDatabase;

    protected $package;
    protected $packageParser;

	public function setUp()
	{
		parent::setUp();

        $this->packageParser = $this->app->make('App\Service\PackageParser');

        Storage::fake('packages');

        $package = new Package;
        $package->slug = 'test-plugin';

        Storage::disk('packages')->put('test-plugin.zip', file_get_contents(resource_path('testing/test-plugin.zip')));

        $metadata = $this->packageParser->parsePackageMetadata($package);
        
        $package->name = $metadata['name'];
        $package->version = $metadata['version'];
        $package->last_metadata = $metadata;
        $package->save();

        $this->package = $package;
	}

    /**
     * Test if you can successfully retreive metadata for a given package.
     * @group packageMetadata
     * @return void
     */
    public function testGetPackageMetadataWithoutActivation()
    {
        $response = $this->json('GET', '/api/v1/packages/' . $this->package->slug . '/metadata');

        $response
            ->assertJsonStructure(['last_updated'])
            ->assertJsonMissing(['download_url'])
            ->assertJson(json_decode('{"name":"Test Plugin","slug":"test-plugin","version":"1.5.1","homepage":"https:\/\/testplugin.com","author":"Capevace","author_homepage":"https:\/\/github.com\/Capevace","details_url":"https:\/\/testplugin.com","type":"plugin","requires":"3.8","tested":"4.9","sections":{"description":"Description here.","installation":"Installation here.","frequently_asked_questions":"= Question =\n\nAnswer\n\n= Question 2 =\n\nAnswer 2","screenshots":"1. WooCommerce Germanized Settings","changelog":"= 2.0.0 =\n* Improvement\n\n= 1.0.0 =\n* Initial Version","upgrade_notice":"= 2.0.0 =\nUpgrade Notice"}}', true));
    }

    /**
     * Test if you can successfully retreive metadata for a given package including a download link if we pass a valid activation.
     * @group packageMetadata
     * @return void
     */
    public function testGetPackageMetadataWithValidActivation()
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

        $response->assertJsonStructure(['activation_id']);

        $activationId = $response->original['activation_id'];

        $response2 = $this->json('GET', '/api/v1/packages/' . $this->package->slug . '/metadata', [
            'activation' => $activationId
        ]);

        $response2
            ->assertJsonStructure(['last_updated'])
            ->assertJson(['download_url' => 'https://wpls.lab/api/v1/packages/test-plugin/download?activation=' . $activationId])
            ->assertJson(json_decode('{"name":"Test Plugin","slug":"test-plugin","version":"1.5.1","homepage":"https:\/\/testplugin.com","author":"Capevace","author_homepage":"https:\/\/github.com\/Capevace","details_url":"https:\/\/testplugin.com","type":"plugin","requires":"3.8","tested":"4.9","sections":{"description":"Description here.","installation":"Installation here.","frequently_asked_questions":"= Question =\n\nAnswer\n\n= Question 2 =\n\nAnswer 2","screenshots":"1. WooCommerce Germanized Settings","changelog":"= 2.0.0 =\n* Improvement\n\n= 1.0.0 =\n* Initial Version","upgrade_notice":"= 2.0.0 =\nUpgrade Notice"}}', true));
    }

    /**
     * Test if you retreive metadata for a given package EXcluding a download link if we pass invalid activation.
     * @group packageMetadata
     * @return void
     */
    public function testGetPackageMetadataWithInvalidActivation()
    {
        $response2 = $this->json('GET', '/api/v1/packages/' . $this->package->slug . '/metadata', [
            'activation' => 'invalid-activation-id'
        ]);

        $response2
            ->assertJsonStructure(['last_updated'])
            ->assertJsonMissing(['download_url'])
            ->assertJson(json_decode('{"name":"Test Plugin","slug":"test-plugin","version":"1.5.1","homepage":"https:\/\/testplugin.com","author":"Capevace","author_homepage":"https:\/\/github.com\/Capevace","details_url":"https:\/\/testplugin.com","type":"plugin","requires":"3.8","tested":"4.9","sections":{"description":"Description here.","installation":"Installation here.","frequently_asked_questions":"= Question =\n\nAnswer\n\n= Question 2 =\n\nAnswer 2","screenshots":"1. WooCommerce Germanized Settings","changelog":"= 2.0.0 =\n* Improvement\n\n= 1.0.0 =\n* Initial Version","upgrade_notice":"= 2.0.0 =\nUpgrade Notice"}}', true));
    }

    /**
     * Test if we can download a package if we are authenticated.
     * @group packageMetadata
     * @return void
     */
    public function testDownloadPackageWithValidActivation()
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

        $response->assertJsonStructure(['activation_id']);

        $activationId = $response->original['activation_id'];

        $response2 = $this->json('GET', '/api/v1/packages/' . $this->package->slug . '/download', [
            'activation' => $activationId
        ]);

        $response2
            ->assertStatus(200)
            ->assertHeader('content-type', 'application/zip')
            ->assertHeader('content-length', 2021)
            ->assertHeader('content-disposition', 'attachment; filename="test-plugin.zip"');
    }

    /**
     * Test if we cant download a package if we are not authenticated.
     * @group packageMetadata
     * @return void
     */
    public function testDownloadPackageWithInvalidActivation()
    {
        $response2 = $this->json('GET', '/api/v1/packages/' . $this->package->slug . '/download', [
            'activation' => 'invalid-activation-id'
        ]);

        $response2
            ->assertStatus(401);
    }
}
