<?php

namespace Feature\Api\V1;

use App\Models\Administrator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TokenControllerTest extends TestCase
{
    use RefreshDatabase;

    private Administrator $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Administrator::factory()->create();
    }

    public function test_guest_can_store_token(): void
    {
        Sanctum::actingAs($this->admin);

        $response = $this->post('/api/v1/tokens', [
            'email' => $this->admin->email,
            'password' => 'password',
        ]);

        $response->assertSuccessful();
        $response->assertJsonStructure(['token']);
    }

    public function test_administrator_can_revoke_token(): void
    {
        $this->admin = Administrator::factory()->create();
        $token = $this->admin->createToken('API Token')->plainTextToken;

        Sanctum::actingAs($this->admin);

        $response = $this->delete('/api/v1/tokens');

        $response->assertNoContent();
    }
}
