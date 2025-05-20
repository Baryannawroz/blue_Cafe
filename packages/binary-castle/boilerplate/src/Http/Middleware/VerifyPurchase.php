<?php

namespace BinaryCastle\Boilerplate\Http\Middleware;

use BinaryCastle\Boilerplate\Static\Installer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class VerifyPurchase
{

    /**
     * Verify purchase
     *
     * @var array|string[]
     */

    public function handle(Request $request, Closure $next): Response
    {
        $currentUrl = $request->route()->uri();

        if (!in_array($currentUrl, Installer::$WHITELISTED_URLS) && !$this->isVerified($request)) {
            return redirect(Installer::$VERIFY_REDIRECT_URL)->withErrors([
                'server_error' => 'You need to verify your purchase before move on to use this application'
            ]);
        }

        return $next($request);
    }

    private function isVerified(Request $request): bool
    {
        $verify_text = Storage::disk('local')->get(Installer::$VERIFY_FILE_NAME);
        if ($verify_text) return true;
        return false;
    }


}
