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

        return response()->json([
            'message' => 'Create profiles successfully',
        ], StatusResponse::SUCCESS);
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

    public function updateProfiles($data) {
        $items = $data['items'];
        foreach($items as $item) {
            if(!$this->isProfileOfUser(auth()->user()->id, $item['id'])) {
                return response()->json([
                    'message' => 'This user have not this profiles'
                ], StatusResponse::ERROR);;
            }
        }

        foreach ($items as $item) {
            Profile::where('id', $item['id'])->update($item['data']);
        }

        return response()->json([
            'message' => 'Update profiles successfully',
        ], StatusResponse::SUCCESS);
    }

    private function isProfileOfUser($userId, $profileId) {
        $profile = Profile::where('id', $profileId)->where('user_id', $userId)->first();

        if (!$profile) return false;
        
        return true;
    }

    public function deleteProfiles($data) {
        $ids = $data['ids'];
        foreach ($ids as $id) {
            if (!$this->isProfileOfUser(auth()->user()->id, $id)) {
                return response()->json([
                    'message' => 'This user have not this profiles'
                ], StatusResponse::ERROR);
                ;
            }
        }

        Profile::destroy($ids);

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