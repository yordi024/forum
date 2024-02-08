<?php

namespace App\Providers;

use Inertia\Testing\AssertableInertia;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Testing\TestResponse;

class TestingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (!$this->app->runningUnitTests()) {
            return;
        }

        AssertableInertia::macro('hasResource', function(string $key, JsonResource $resource) {
            /** @var AssertableInertia $this */
            $this->has($key);

            expect($this->prop($key))->toEqual($resource->response()->getData(true));

            return $this;
        });

        AssertableInertia::macro('hasPaginatedResource', function(string $key, ResourceCollection $resource) {
            /** @var AssertableInertia $this */
            $this->hasResource("{$key}.data", $resource);

            expect($this->prop($key))->toHaveKeys(['data', 'links', 'meta']);

            return $this;
        });

        TestResponse::macro('assertHasResource', function(string $key, JsonResource $resource) {
            /** @var AssertableInertia $this */
            return $this->assertInertia(fn(AssertableInertia $inertia) => $inertia->hasResource($key, $resource));
        });

        TestResponse::macro('assertHasPaginatedResource', function(string $key, ResourceCollection $resource) {
            /** @var AssertableInertia $this */
            return $this->assertInertia(fn(AssertableInertia $inertia) => $inertia->hasPaginatedResource($key, $resource));
        });
    }
}
