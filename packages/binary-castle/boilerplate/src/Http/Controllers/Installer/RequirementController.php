<?php

namespace BinaryCastle\Boilerplate\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
    public function index()
    {
        $requirements = config('boilerplate.requirements.php');
        return view('boilerplate::installer.requirements', compact('requirements'));
    }

    public function save(Request $request)
    {
        if ($request->server_requirement_satisfy) {
            return redirect()->to($request->next_route);
        } else {
            return redirect()->back()->withErrors(['server_requirement_satisfy' => 'Server requirements are not satisfied']);
        }
    }
}
