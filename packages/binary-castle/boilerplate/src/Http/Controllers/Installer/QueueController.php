<?php

namespace BinaryCastle\Boilerplate\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use BinaryCastle\Boilerplate\Http\Requests\Installer\QueueSetupRequest;
use Brotzka\DotenvEditor\DotenvEditor;
use Illuminate\Validation\ValidationException;

class QueueController extends Controller
{
    /**
     * Show the queue setup form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('boilerplate::installer.queue');
    }

    /**
     * Save the queue configuration.
     *
     * @param QueueSetupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function save(QueueSetupRequest $request)
    {
        try {
            // Set the default queue connection
            config(['queue.default' => $request->connection]);

            // Update environment variables
            $this->updateEnvironmentVariables($request);

            return redirect()->to($request->next_route)
                ->with('success', 'Queue configuration has been saved successfully.');
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'server_error' => 'Failed to save configuration: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Update environment variables based on the queue configuration.
     *
     * @param QueueSetupRequest $request
     * @return void
     */
    private function updateEnvironmentVariables(QueueSetupRequest $request)
    {
        $env = new DotenvEditor();
        $envUpdates = [
            'QUEUE_CONNECTION' => $request->connection,
            'QUEUE_FAILED_DRIVER' => $request->failed_driver,
        ];

        // Add driver-specific environment variables
        switch ($request->connection) {
            case 'redis':
                $envUpdates['REDIS_QUEUE'] = $request->redis_queue;
                break;

            case 'sqs':
                $envUpdates['AWS_ACCESS_KEY_ID'] = $request->aws_access_key_id;
                $envUpdates['AWS_SECRET_ACCESS_KEY'] = $request->aws_secret_access_key;
                $envUpdates['AWS_DEFAULT_REGION'] = $request->aws_default_region;
                $envUpdates['SQS_QUEUE'] = $request->sqs_queue;
                break;

            case 'beanstalkd':
                // Store custom beanstalkd configuration if needed
                if ($request->filled('beanstalkd_host') && $request->beanstalkd_host !== 'localhost') {
                    $envUpdates['BEANSTALKD_HOST'] = $request->beanstalkd_host;
                }

                if ($request->filled('beanstalkd_queue') && $request->beanstalkd_queue !== 'default') {
                    $envUpdates['BEANSTALKD_QUEUE'] = $request->beanstalkd_queue;
                }
                break;
        }

        // Update the .env file
        $env->changeEnv($envUpdates);
    }
}
