<?php

namespace BinaryCastle\Boilerplate\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use BinaryCastle\Boilerplate\Http\Requests\Installer\DatabaseSetupRequest;
use Brotzka\DotenvEditor\DotenvEditor;
use Dotenv\Dotenv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    public function index()
    {
        $db_connection = config('database.connections.mysql');
        return view('boilerplate::installer.database', compact('db_connection'));
    }

    public function save(DatabaseSetupRequest $request)
    {
        config([
            'database.connections.mysql.host' => "$request->host",
            'database.connections.mysql.port' => $request->port,
            'database.connections.mysql.username' => "$request->username",
            'database.connections.mysql.password' => "$request->password",
            'database.connections.mysql.database' => "$request->database",
        ]);
        DB::purge('mysql');
        try {
            DB::connection()->getPdo();
            DB::connection()->getDatabaseName();
            $this->setConfigInEnv($request);
            Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
//            Artisan::call('config:cache');
            return redirect()->to($request->next_route);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['server_error' => $e->getMessage()]);
        }
    }

    private function setConfigInEnv($request)
    {
        $env = new DotenvEditor();
        $env->changeEnv([
            'DB_HOST' => "\"{$request->host}\"",
            'DB_PORT' => "{$request->port}",
            'DB_DATABASE' => "\"{$request->database}\"",
            'DB_USERNAME' => "\"{$request->username}\"",
            'DB_PASSWORD' => "\"{$request->password}\"",
        ]);
    }
}
