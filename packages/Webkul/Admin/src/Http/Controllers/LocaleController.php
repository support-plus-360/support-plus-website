<?php

namespace Webkul\Admin\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    /**
     * Switch the admin panel locale for the current session.
     */
    public function switch(string $locale): RedirectResponse
    {
        $available = array_keys(config('app.available_locales', []));

        if (! in_array($locale, $available, true)) {
            abort(404);
        }

        session(['admin_locale' => $locale]);

        return redirect()
            ->back()
            ->withCookie(cookie()->forever('admin_locale', $locale));
    }
}
