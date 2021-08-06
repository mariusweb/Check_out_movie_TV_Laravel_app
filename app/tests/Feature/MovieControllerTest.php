<?php


namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\User;

class MovieControllerTest extends TestCase
{
    public function testMovieList()
    {
        $user = User::factory()->create();
        Auth::loginUsingId(1);
        $response = $this->get('/profile');
        $response->assertStatus(200);
    }
}
