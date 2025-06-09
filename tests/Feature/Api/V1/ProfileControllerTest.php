<?php

namespace Feature\Api\V1;

use App\Enums\ProfileStatus;
use App\Models\Administrator;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
