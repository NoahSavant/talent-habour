<?php

namespace App\Http\Controllers\Api;

use App\Constants\AuthenConstant\StatusResponse;
use App\Http\Controllers\Controller;
use App\Services\ModelServices\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return $this->userService->getAllUser();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $result = $this->userService->delete($request->get('ids'));

        if ($result) {
            return response()->json([
                'message' => 'Delete user successfully',
            ], StatusResponse::SUCCESS);
        }

        return response()->json([
            'message' => 'Delete user fail',
        ], StatusResponse::ERROR);
    }

    public function updateProfile(Request $request)
    {
        $result = $this->userService->updateProfile(auth()->user(), $request->all());

        if ($result) {
            return response()->json($result, StatusResponse::SUCCESS);
        }

        return response()->json([
            'message' => 'Update profile fail',
        ], StatusResponse::ERROR);
    }

    public function updateUserProfile(string $id, Request $request)
    {
        $user = User::where('id', $id)->first();
        $result = $this->userService->updateProfile($user, $request->all());

        if ($result) {
            return response()->json($result, StatusResponse::SUCCESS);
        }

        return response()->json([
            'message' => 'Update profile fail',
        ], StatusResponse::ERROR);
    }
}
