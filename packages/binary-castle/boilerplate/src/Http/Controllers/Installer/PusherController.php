<?php

namespace BinaryCastle\Boilerplate\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use Brotzka\DotenvEditor\Exceptions\DotEnvException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\ValidationException;
use Brotzka\DotenvEditor\DotenvEditor;

class PusherController extends Controller
{
    /**
     * Show the pusher setup form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $broadcastConfig = config('broadcasting');
        return view('boilerplate::installer.pusher', compact('broadcastConfig'));
    }

    /**
     * Save the pusher configuration.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function save(Request $request)
    {
        // Validate the request based on the selected broadcaster
        $this->validateRequest($request);

        try {
            // Update environment variables
            $this->updateEnvironmentVariables($request);

            // Clear config cache
            Artisan::call('config:clear');

            return redirect()->to($request->next_route);
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'server_error' => 'Failed to save configuration: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Validate the request based on the selected broadcaster.
     *
     * @param Request $request
     * @return array
     */
    private function validateRequest(Request $request)
    {
        $rules = [
            'broadcast_driver' => 'required|in:pusher,redis,log,null',
        ];

        if ($request->input('broadcast_driver') === 'pusher') {
            $rules = array_merge($rules, [
                'pusher_app_id' => 'required',
                'pusher_key' => 'required',
                'pusher_secret' => 'required',
                'pusher_cluster' => 'required',
            ]);
        } elseif ($request->input('broadcast_driver') === 'redis') {
            $rules = array_merge($rules, [
                'redis_connection' => 'required',
            ]);
        }

        return $request->validate($rules);
    }

    /**
     * Update environment variables using DotenvEditor.
     *
     * @param Request $request
     * @return void
     * @throws DotEnvException
     */
    private function updateEnvironmentVariables(Request $request): void
    {
        $env = new DotenvEditor();
        $envUpdates = [
            'BROADCAST_DRIVER' => $request->input('broadcast_driver'),
        ];

        // Add driver-specific environment variables
        if ($request->input('broadcast_driver') === 'pusher') {
            $envUpdates = array_merge($envUpdates, [
                'PUSHER_APP_ID' => $request->input('pusher_app_id'),
                'PUSHER_APP_KEY' => $request->input('pusher_key'),
                'PUSHER_APP_SECRET' => $request->input('pusher_secret'),
                'PUSHER_OPTION_CLUSTER' => $request->input('pusher_cluster'),
                'PUSHER_OPTION_ENCRYPTED' => $request->has('pusher_encrypted') ? 'true' : 'false',
            ]);
        }

        // Update the .env file
        $env->changeEnv($envUpdates);
    }
}
