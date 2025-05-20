<?php

namespace BinaryCastle\Boilerplate\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class InstallerController extends Controller
{

    /**
     * @return Application|Factory|View
     */
    public function pusher(): View|Factory|Application
    {
        return view('boilerplate::installer.pusher');
    }


    public function installationComplete()
    {
        $fileName = 'install.txt';
        $fileContent = "setup-complete";
        Storage::disk('local')->put($fileName, $fileContent);
        return view('boilerplate::installer.finish');
    }
}
