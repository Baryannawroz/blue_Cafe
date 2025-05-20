<?php

namespace BinaryCastle\Boilerplate\Http\Middleware;

use BinaryCastle\Boilerplate\Static\Installer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class VerifyInstall
{
    public function handle(Request $request, Closure $next): Response
    {
        $currentUrl = $request->route()->uri();

        if (in_array($currentUrl, Installer::$WHITELISTED_URLS)) {
            return $next($request);
        }

        if (config('boilerplate.installation_required') && !$this->isInstall($request)) {
            return redirect(Installer::$BASE_INSTALL_URL)->withErrors([
                'server_error' => 'Please install before use'
            ]);
        }

        return $next($request);
    }

    private function isInstall(Request $request)
    {

        $verify_text = Storage::disk('local')->get(Installer::$VERIFY_FILE_NAME);
        if ($verify_text) return true;
        return false;
    }
}
