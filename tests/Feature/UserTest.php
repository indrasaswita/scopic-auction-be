<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use JWTAuth;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_abcde_test_lagi()
    {
        echo "\n";
        $response = $this->get('/api/itemcategory/all');

        $response->assertStatus(200);
        echo "> itemcategory/all passed\n";

        $user = User::find(1);
        $token = JWTAuth::fromUser($user);
        $response = $this->actingAs($user)
            ->get('/api/item/list?paginate=12', [
                'Authorization' => 'Bearer ' . $token,
            ]);

        $response->assertStatus(200);
        echo "> item/list passed\n";
    }
}
