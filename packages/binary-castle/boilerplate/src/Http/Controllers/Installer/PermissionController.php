<?php

namespace BinaryCastle\Boilerplate\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = config('boilerplate.permissions');
        $directoryPermissions = [];
        foreach ($permissions as $key => $permission) {
            $path = base_path($key);
            $isWritable = File::isWritable($path);
            $hasPermission = $isWritable && File::chmod($path, octdec($permission));

            $directoryPermissions[] = [
                'directory' => $key,
                'isWritable' => $isWritable,
                'hasPermission' => $hasPermission,
                'permission' => $permission
            ];
        }
        return view('boilerplate::installer.permissions', compact('directoryPermissions'));
    }

    public function save(Request $request)
    {
        if ($request->server_requirement_satisfy) {
            try {
                Artisan::call('storage:link');
                return redirect()->to($request->next_route);
            } catch (Exception $e) {
                return redirect()->back()->withErrors(['server_error' => $e->getMessage()]);
            }
        } else {
            return redirect()->back()->withErrors(['server_error' => 'Server requirements are not satisfied']);
        }


    }
}
