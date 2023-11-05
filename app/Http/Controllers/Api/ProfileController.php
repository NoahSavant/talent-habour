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
    public function index($userId)
    {
        return $this->profileService->getProfilesOfUser($userId);
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
        return $this->profileService->createProfile($request->all());
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
    public function update(Request $request, string $id)
    {
        return $this->profileService->updateProfile($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->profileService->deleteProfile($id);
    }
}
