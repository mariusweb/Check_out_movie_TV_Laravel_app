<?php


namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileControllerTest extends TestCase
{
    public function test_profile_user()
    {
        $user = User::factory()->create();
        Auth::loginUsingId(1);
        $response = $this->get('/profile');
        $response->assertStatus(200);
    }
}
