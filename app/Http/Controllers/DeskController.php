<?php

namespace App\Http\Controllers;

use App\Models\Desk;
use App\Http\Requests\StoreDeskRequest;
use App\Http\Requests\UpdateDeskRequest;

class DeskController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeskRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Desk $desk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Desk $desk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeskRequest $request, Desk $desk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Desk $desk)
    {
        //
    }
}
