<?php

namespace Feature\Api\V1;

use App\Enums\ProfileStatus;
use App\Models\Administrator;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    private Administrator $admin;

    private Profile $profile;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Administrator::factory()->create();
        $this->profile = Profile::factory()->create(['status' => ProfileStatus::Active->value]);
    }

    public function test_administrator_can_store_one_comment_on_profile(): void
    {
        Sanctum::actingAs($this->admin);

        $response = $this->post('/api/v1/profiles/'.$this->profile->id.'/comments', [
            'content' => 'This is a test comment.',
        ]);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'content',
                'profile_id',
            ],
        ]);
    }
}
