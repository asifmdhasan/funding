<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{

    public function handle(Request $request, Closure $next)
    {
        
        $supportedLocales = ['en', 'jp'];
        $locale = $request->query('lang') ?? session('locale') ?? 'en';
        
        if (in_array($locale, $supportedLocales)) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        } else {
            App::setLocale('en'); // default to jp
            Session::put('locale', 'en');
        }

        return $next($request);
    }
}
