<?php

namespace Webkul\Admin\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class Locale
{
    /**
     * The middleware instance.
     *
     * @return void
     */
    public function __construct(
        Application $app,
        Request $request
    ) {
        $this->app = $app;

        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $available = array_keys(config('app.available_locales', []));

        $locale = session('admin_locale')
            ?? $request->cookie('admin_locale')
            ?? core()->getConfigData('general.general.locale_settings.locale')
            ?? app()->getLocale();

        if (in_array($locale, $available, true)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
