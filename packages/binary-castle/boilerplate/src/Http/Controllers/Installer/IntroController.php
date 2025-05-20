<?php

namespace BinaryCastle\Boilerplate\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use DateTimeZone;
use Illuminate\Support\Facades\Request as RequestScope;
use Brotzka\DotenvEditor\DotenvEditor;
use Illuminate\Http\Request;

class IntroController extends Controller
{
    public function index()
    {
        return view('boilerplate::installer.intro');
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'agreement' => 'required',
            'next_route' => 'required',
            'timezone' => [
                'required',
                'string',
                fn($attribute, $value, $fail) => !in_array($value, DateTimeZone::listIdentifiers())
                    ? $fail("The selected timezone is invalid.")
                    : null
            ],
        ]);
        $this->setAppUrl();
        $this->setTimezone($request);
        return redirect()->to($request->next_route);
    }

    private function setAppUrl()
    {
        $env = new DotenvEditor();
        $domain = RequestScope::getHost();
        $protocol = RequestScope::getScheme();
        $env->changeEnv([
            'APP_URL' => "{$protocol}://{$domain}",
        ]);
    }

    private function setTimezone(Request $request)
    {
        config(['app.timezone' => $request->timezone]);

        $env = new DotenvEditor();
        $env->changeEnv([
            'APP_TIMEZONE' => "\"{$request->timezone}\""
        ]);
    }
}
