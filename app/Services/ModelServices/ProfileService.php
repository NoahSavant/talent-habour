<?php

namespace App\Services\ModelServices;

use App\Constants\AuthenConstant\StatusResponse;
use App\Constants\ProfileConstant\ProfileContentType;
use App\Constants\ProfileConstant\ProfileType;
use App\Constants\UserConstant\UserGender;
use App\Models\Profile;
use App\Models\User;

class ProfileService extends BaseService
{
    public function __construct(Profile $profile) {
        $this->model = $profile;
    }

    public function getProfiles()
    {
        $profiles = auth()->user()->profiles;
        return $profiles;
    }

    public function createProfiles($user, $profiles) {
        foreach ($profiles as $profile) {
            $this->create([
                "user_id" => $user->id,
                "title" => $profile['title'],
                "content" => $profile['content'],
                "type" => $profile['type'],
                "content_type" => $profile['content_type'],
                "image_url" => $profile['image_url'],
            ]);
        }
    }

    public function setUpProfile($user) {
        $profiles = [
            [
                "title" => "Date of birth",
                "content" => null,
                "type"=> ProfileType::INTRODUCE,
                "content_type" => ProfileContentType::TEXT,
                "image_url" => null,
            ],
            [
                "title" => "Gender",
                "content" => UserGender::OTHER,
                "type"=> ProfileType::INTRODUCE,
                "content_type" => ProfileContentType::TEXT,
                "image_url" => null,
            ],
            [
                "title" => "Phone number",
                "content" => "",
                "type" => ProfileType::INTRODUCE,
                "content_type" => ProfileContentType::TEXT,
                "image_url" => null,
            ]
        ];

        $this->createProfiles($user, $profiles);
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