<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ModelServices\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService) {
        $this->profileService = $profileService;
    }
    public function index()
    {
        return $this->profileService->getProfiles();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->profileService->createProfiles(auth()->user(), $request->all()['items']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->profileService->getProfile($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        return $this->profileService->updateProfiles($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->profileService->deleteProfiles($request->all());
    }
}
