<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use RuntimeException;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    public const HOME = '/home';

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            foreach ($this->centralDomains() as $domain) {
                Route::prefix('api')
                    ->domain($domain)
                    ->middleware([
                        'api',
                        InitializeTenancyByDomain::class,
                        PreventAccessFromCentralDomains::class,
                    ])->group(base_path('routes/api.php'));

                Route::middleware('web')
                    ->domain($domain)
                    ->group(base_path('routes/web.php'));
            }
        });
    }

    /**
     * @return array
     */
    protected function centralDomains(): array
    {
        $domains = config('tenancy.central_domains');

        if (! is_array($domains)) {
            throw new RuntimeException(
                message: "Tenanct Central Domains should be an array",
            );
        }

        return (array) $domains;
    }

    /**
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', fn (Request $request) =>
            /** @phpstan-ignore-next-line  */
            Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip())
        );
    }
}
