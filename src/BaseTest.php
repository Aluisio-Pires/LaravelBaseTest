<?php
namespace AluisioPires\LaravelBaseTest;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class BaseTest extends TestCase
{
    protected function isProtected($method, $route, $request = [])
    {
        if (Auth::check()) {
            foreach (config('auth.guards') as $guardName => $guardConfig) {
                Auth::guard($guardName)->forget();
            }
        }
        $this->assertGuest();

        $response = $this->json($method,
            $route,
            $request,
        );
        $response->assertStatus(401);
    }

    protected function simpleRequest($method, $route, $status = 200, $request = [], $user = null)
    {
        $user = $user ?: User::factory()->create();
        $response = $this->actingAs($user)->json($method,
            $route,
            $request
        );
        if ($response->status() !== $status) {
            dump($response->json());
        }
        $response->assertStatus($status);

        return $response;
    }

    protected function simpleTest($method, $route, $status = 200, $request = [], $user = null)
    {
        $this->isProtected($method, $route, $request);
        return $this->simpleRequest($method, $route, $status, $request, $user);
    }
}
