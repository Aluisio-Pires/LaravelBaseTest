<?php
namespace AluisioPires\LaravelBaseTest;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class BaseTest extends TestCase
{
    public function __construct($traits = [])
    {
        $this->setUpBaseTraits($traits);
        parent::__construct();
    }

    protected function setUpBaseTraits($traits = [])
    {
        if (isset($traits['RefreshDatabase'])) {
            $this->refreshDatabase();
        }

        if (isset($traits['DatabaseMigrations'])) {
            $this->runDatabaseMigrations();
        }

        if (isset($traits['DatabaseTruncation'])) {
            $this->truncateDatabaseTables();
        }

        if (isset($traits['DatabaseTransactions'])) {
            $this->beginDatabaseTransaction();
        }

        if (isset($traits['WithoutMiddleware'])) {
            $this->disableMiddlewareForAllTests();
        }

        if (isset($traits['WithoutEvents'])) {
            $this->disableEventsForAllTests();
        }

        if (isset($traits['WithFaker'])) {
            $this->setUpFaker();
        }

        foreach ($traits as $trait) {
            if (method_exists($this, $method = 'setUp'.class_basename($trait))) {
                $this->{$method}();
            }
        }

        return $traits;
    }


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

    protected function simpleTest($method, $route, $status = 200, $request = [], $user = null, $protected = true)
    {
        if ($protected){
            $this->isProtected($method, $route, $request);
        }
        return $this->simpleRequest($method, $route, $status, $request, $user);
    }
}
