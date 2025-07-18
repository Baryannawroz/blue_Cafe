<?php

namespace App\Http\Controllers;

use App\Models\Reason;
use App\Http\Requests\StoreReasonRequest;
use App\Http\Requests\UpdateReasonRequest;

class ReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.admin.accountant.add-reason');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReasonRequest $request)
    {
        Reason::create($request->validated());
        return redirect("/add-expense");
    }


    public function show(Reason $reason)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reason $reason)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReasonRequest $request, Reason $reason)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reason $reason)
    {
        //
    }
}
