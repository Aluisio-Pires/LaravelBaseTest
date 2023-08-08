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
                $guard = Auth::guard($guardName);
                if (method_exists($guard, 'forgetUser')) {
                    $guard->forgetUser();
                }
            }
        }
        $this->assertGuest();

        $response = $this->json(
            $method,
            $route,
            $request,
        );
        $response->assertStatus(401);
    }

    protected function simpleRequest($method, $route, int $status = 200, $request = [], User|null $user = null, $headers = [])
    {
        $user = $user ?: User::factory()->create();
        $response = $this->actingAs($user)->withHeaders($headers)->json(
            $method,
            $route,
            $request
        );
        if ($response->status() !== $status) {
            dump($response->json());
        }
        $response->assertStatus($status);

        return $response;
    }

    protected function simpleTest($method, $route, int $status = 200, $request = [], User|null $user = null, $protected = true, $headers = [])
    {
        if ($protected) {
            $this->isProtected($method, $route, $request);
        }
        return $this->simpleRequest($method, $route, $status, $request, $user, $headers);
    }
}
