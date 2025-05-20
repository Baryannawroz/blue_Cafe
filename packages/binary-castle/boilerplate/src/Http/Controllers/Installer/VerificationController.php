<?php

namespace BinaryCastle\Boilerplate\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use BinaryCastle\Boilerplate\Http\Requests\Installer\PurchaseVerifyRequest;
use BinaryCastle\Boilerplate\Rules\VerifyPurchaseCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VerificationController extends Controller
{
    public function index()
    {
        return view('boilerplate::installer.verify');
    }

    public function save(PurchaseVerifyRequest $request)
    {
        return redirect()->to($request->next_route);
    }
}
