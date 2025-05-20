<?php

namespace BinaryCastle\Boilerplate\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use BinaryCastle\Boilerplate\Http\Requests\Installer\LogSetupRequest;
use Brotzka\DotenvEditor\DotenvEditor;
use Brotzka\DotenvEditor\Exceptions\DotEnvException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class LogController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        $log_default = config('logging.default');
        $slack_url = config('logging.channels.slack.url');
        return view('boilerplate::installer.logs', compact('log_default', 'slack_url'));
    }

    /**
     * @param LogSetupRequest $request
     * @return RedirectResponse
     * @throws DotEnvException
     */
    public function save(LogSetupRequest $request)
    {
        $this->setConfigInEnv($request);
        return redirect()->to($request->next_route);
    }

    /**
     * @param $request
     * @return void
     * @throws DotEnvException
     */
    private function setConfigInEnv($request)
    {
        $env = new DotenvEditor();
        $env->changeEnv([
            'LOG_CHANNEL' => "{$request->log_channel}",
            'LOG_SLACK_WEBHOOK_URL' => "{$request->slack_url}",
        ]);
    }
}
