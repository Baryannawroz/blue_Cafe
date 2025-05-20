<?php

namespace BinaryCastle\Boilerplate\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use BinaryCastle\Boilerplate\Http\Requests\Installer\EmailSetupRequest;
use BinaryCastle\Boilerplate\Mail\TestEmail;
use Brotzka\DotenvEditor\DotenvEditor;
use Exception;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index()
    {
        $mailConfig = config('mail.mailers.smtp');
        $mailFromConfig = config('mail.from');
        return view('boilerplate::installer.mail', compact('mailConfig', 'mailFromConfig'));
    }

    public function save(EmailSetupRequest $request)
    {
        config([
            'mail.mailers.smtp.encryption' => $request->encryption == 'null' ? null : $request->encryption,
            'mail.mailers.smtp.host' => $request->host,
            'mail.mailers.smtp.port' => (int)$request->port,
            'mail.mailers.smtp.username' => "$request->username",
            'mail.mailers.smtp.password' => "$request->password",
            'mail.from.address' => "$request->mail_from_address",
            'mail.from.name' => "$request->mail_from_name",
            'mail.default' => "$request->transport",
        ]);
        try {
            Mail::to('kmrifat@gmail.com')->send(new TestEmail());
            $this->setConfigInEnv($request);
            //            Artisan::call('config:cache');
            return redirect()->to($request->next_route);
        } catch (Exception $exception) {
            throw $exception;
            return redirect()->back()->withErrors(['server_error' => $exception->getMessage()])->withInput();
        }

        return 'ok';
    }

    private function setConfigInEnv($request)
    {
        $env = new DotenvEditor();
        $env->changeEnv([
            'MAIL_HOST' => "\"{$request->host}\"",
            'MAIL_PORT' => (int)$request->port,
            'MAIL_USERNAME' => "\"{$request->username}\"",
            'MAIL_PASSWORD' => "\"{$request->password}\"",
            'MAIL_ENCRYPTION' => $request->encryption == 'null' ? null : "$request->encryption",
            'MAIL_FROM_ADDRESS' => "\"{$request->mail_from_address}\"",
            'MAIL_FROM_NAME' => "\"{$request->mail_from_name}\"",
            'MAIL_MAILER' => "\"{$request->transport}\"",
        ]);
    }
}
