<?php

namespace BinaryCastle\Boilerplate\Http\Requests\Installer;

use Illuminate\Foundation\Http\FormRequest;

class QueueSetupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'connection' => 'required|in:sync,database,redis,sqs,beanstalkd',
            'failed_driver' => 'required|in:database,database-uuids,null',
        ];

        // Add specific rules based on the selected queue driver
        switch ($this->input('connection')) {
            case 'redis':
                $rules['redis_queue'] = 'required|string';
                break;

            case 'sqs':
                $rules['aws_access_key_id'] = 'required|string';
                $rules['aws_secret_access_key'] = 'required|string';
                $rules['aws_default_region'] = 'required|string';
                $rules['sqs_queue'] = 'required|string';
                break;

            case 'beanstalkd':
                $rules['beanstalkd_host'] = 'required|string';
                $rules['beanstalkd_queue'] = 'required|string';
                break;
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'connection.required' => 'Please select a queue driver.',
            'connection.in' => 'Selected queue driver is not valid.',
            'failed_driver.required' => 'Please select a failed jobs driver.',
            'failed_driver.in' => 'Selected failed jobs driver is not valid.',
            'redis_queue.required' => 'Redis queue name is required.',
            'aws_access_key_id.required' => 'AWS Access Key ID is required for SQS.',
            'aws_secret_access_key.required' => 'AWS Secret Access Key is required for SQS.',
            'aws_default_region.required' => 'AWS Region is required for SQS.',
            'sqs_queue.required' => 'SQS queue name is required.',
            'beanstalkd_host.required' => 'Beanstalkd host is required.',
            'beanstalkd_queue.required' => 'Beanstalkd queue name is required.',
        ];
    }
}
