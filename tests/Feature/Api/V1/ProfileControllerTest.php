<?php

namespace Feature\Api\V1;

use App\Enums\ProfileStatus;
use App\Models\Administrator;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    private Administrator $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Administrator::factory()->create();

        Profile::factory(10)->create(['status' => ProfileStatus::Active->value]);
        Profile::factory(10)->create(['status' => ProfileStatus::Pending->value]);
    }

    public function test_guest_can_list_active_profiles_without_status(): void
    {
        $response = $this->get('/api/v1/profiles');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'image',
                ],
            ],
        ]);

        $response->assertJsonCount(10, 'data');
        // check that only one page of 10 results is returned
        $response->assertJsonPath('meta.current_page', 1);
        $response->assertJsonPath('meta.last_page', 1);
    }

    public function test_administrator_can_list_active_profiles_with_status(): void
    {
        Sanctum::actingAs($this->admin);

        $response = $this->get('/api/v1/profiles');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'image',
                    'status',
                ],
            ],
        ]);

        // assert that each status element is equal to 'active'
        collect($response->json('data'))->each(function ($profile) {
            $this->assertEquals(ProfileStatus::Active->value, $profile['status']);
        });

        $response->assertJsonCount(10, 'data');
        // check that only one page of 10 results is returned
        $response->assertJsonPath('meta.current_page', 1);
        $response->assertJsonPath('meta.last_page', 1);
    }

    public function test_administrator_can_delete_profile(): void
    {
        /** @var Profile $profile */
        $profile = Profile::factory()->create();

        Sanctum::actingAs($this->admin);

        $response = $this->delete("/api/v1/profiles/$profile->id");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('profiles', [
            'id' => $profile->id,
        ]);
    }

    public function test_administrator_can_update_profile(): void
    {
        Storage::fake('public');

        /** @var Profile $profile */
        $profile = Profile::factory([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'status' => ProfileStatus::Inactive->value,
            'administrator_id' => $this->admin->id,
        ])->create();

        Sanctum::actingAs($this->admin);

        $response = $this->put("/api/v1/profiles/$profile->id", [
            'first_name' => 'Joffrey',
            'last_name' => 'Carle',
            'image' => UploadedFile::fake()->image('profile.jpg', 300, 300),
            'status' => ProfileStatus::Active->value,
        ]);

        $response->assertSuccessful();

        $profile->refresh();
        $this->assertEquals('Joffrey', $profile->first_name);
        $this->assertEquals('Carle', $profile->last_name);
        $this->assertEquals(ProfileStatus::Active->value, $profile->status);

        Storage::disk('public')->assertExists($profile->image);
    }
}
