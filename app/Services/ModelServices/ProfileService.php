<?php

namespace App\Services\ModelServices;

use App\Constants\AuthenConstant\StatusResponse;
use App\Models\Profile;
use App\Models\User;

class ProfileService extends BaseService
{
    public function getProfilesOfUser($userId)
    {
        $profiles = User::where('id', $userId)->profiles;
        return $profiles;
    }

    public function createProfile($data) {
        $profile = Profile::create($data);
        if ($profile) {
            return response()->json([
                'message' => 'Create profile successfully',
                'profile' => $profile
            ], StatusResponse::SUCCESS);
        }

        return response()->json([
            'message'=> 'Create profile fail'
        ], StatusResponse::ERROR);
    }

    public function updateProfile($id, $data) {
        $profile = Profile::where('id', $id)->update($data);
        if ($profile) {
            return response()->json([
                'message' => 'Update profile successfully',
                'profile' => $profile
            ], StatusResponse::SUCCESS);
        }

        return response()->json([
            'message' => 'Update profile fail'
        ], StatusResponse::ERROR);
    }

    public function deleteProfile($id) {
        Profile::where('id', $id)->delete();

        return response()->json([
            'message' => 'Delete profile successfully',
        ], StatusResponse::SUCCESS);
    }

    public function getProfile($id) {
        $profile = Profile::where('id', $id)->first();
        if ($profile) {
            return response()->json([
                'message' => 'Get profile successfully',
                'profile' => $profile
            ], StatusResponse::SUCCESS);
        }

        return response()->json([
            'message' => 'Get profile fail'
        ], StatusResponse::ERROR);
    }

}