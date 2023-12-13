<?php

namespace App\Http\Controllers;

use App\Models\Chef;
use App\Http\Requests\StoreChefRequest;
use App\Http\Requests\UpdateChefRequest;

class ChefController extends Controller
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
    public function store(StoreChefRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Chef $chef)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chef $chef)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChefRequest $request, Chef $chef)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chef $chef)
    {
        //
    }
}
