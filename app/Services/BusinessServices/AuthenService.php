<?php

namespace App\Services\BusinessServices;

use App\Constants\AuthenConstant\SendCodeType;
use App\Constants\AuthenConstant\StatusResponse;
use App\Constants\UserConstant\UserRole;
use App\Constants\UserConstant\UserStatus;
use App\Constants\UserConstant\UserVerifyTime;
use App\Jobs\SendMailQueue;
use App\Models\AccountVerify;
use App\Models\Profile;
use App\Models\User;
use App\Services\ModelServices\AccountVerifyService;
use App\Services\ModelServices\CompanyInformationService;
use App\Services\ModelServices\ProfileService;
use App\Services\ModelServices\UserService;
use DateInterval;
use DateTime;
use Hash;

class AuthenService
{
    protected $userService;

    protected $accountVerifyService;

    protected $companyInformationService;

    public function __construct(UserService $userService, AccountVerifyService $accountVerifyService, CompanyInformationService $companyInformationService) {
        $this->userService = $userService;
        $this->accountVerifyService = $accountVerifyService;
        $this->companyInformationService = $companyInformationService;
    }

    private function response($data, $status) {
        return response()->json($data, $status);
    }

    public function login($input) {
       
        if (!$token = auth()->attempt($input)) {
            return $this->response(["message" => 'Unauthorized'], StatusResponse::UNAUTHORIZED);
        }

        return $this->createNewToken($token);
    }

    public function signup($input)
    {
        if ($this->userService->isEmailExist($input['email'])) {
            return $this->response([
                'message' => 'This email has been used',
            ], StatusResponse::ERROR);
        }

        $data = array_merge(
            $input,
            ['password' => Hash::make($input['password'])],
            ['status' => UserStatus::DEACTIVE]
        );

        $user = $this->setUpUser($data);

        return $this->response([
            'message' => $user ? 'User successfully registered' : 'User fail registered',
            'user' => $user
        ], $user ? StatusResponse::SUCCESS : StatusResponse::ERROR);
    }

    private function setUpUser($data) {
        $user = User::create(
            $data
        );

        if($user->role == UserRole::RECRUITER) {
            $this->companyInformationService->create(['user_id' => $user->id]);
        }

        $this->accountVerifyService->create([
            'user_id'=> $user->id
        ]);

        $this->createVerify($user->email);

        SendMailQueue::dispatch($user);

        return $user;
    }

    private function generateEncodedString($startTime, $endTime, $userData) {
        $dataToEncode = $startTime . '|' . $endTime . '|' . $userData;
        return Hash::make($dataToEncode);
    }

    private function createVerify($email) {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return null; 
        }

        $currentDateTime = new DateTime();
        $overDateTime = clone $currentDateTime;
        $overDateTime->add(new DateInterval(UserVerifyTime::ACTIVE_TIME));

        $verify = $user->accountVerify;
        $verify->verify_code = $this->generateEncodedString($currentDateTime->format('Y-m-d H:i:s'), $overDateTime->format('Y-m-d H:i:s'), json_encode($user));
        $verify->overtimed_at = $overDateTime->format('Y-m-d H:i:s');
        $verify->deleted_at = null;
        $verify->save();

        return $verify->verify_code;
    }

    public function sendVerify($input) {
        $verify_code = $this->createVerify($input['email']);

        if(!$verify_code) {
            return $this->response([
                "message" => 'Can not find out the email'
            ], StatusResponse::ERROR);
        }

        $user = User::where('email', $input['email'])->first();
        SendMailQueue::dispatch($user, SendCodeType::SEND_CODE);

        return $this->response([
            'message'=> 'Send verify code successfully',
        ], StatusResponse::SUCCESS);
    }
    public function logout()
    {
        auth()->logout();
        return $this->response(['message' => 'User successfully signed out'], StatusResponse::SUCCESS);
    }

    public function throwAuthenError()
    {
        return $this->response(["message" => "You need to login to access"], StatusResponse::UNAUTHORIZED);
    }

    public function throwAuthorError()
    {
        return $this->response(["message" => "You do not have permission to access"], StatusResponse::UNAUTHORIZED);
    }

    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    public function getUserProfile()
    {
        return $this->response(auth()->user(), StatusResponse::SUCCESS);
    }

    protected function createNewToken($token)
    {
        $user = auth()->user();

        if($user->status == UserStatus::DEACTIVE) {
            return $this->response([
                "message"=> "Your account is deactived"
            ], StatusResponse::DEACTIVED_ACCOUNT);
        }

        if ($user->status == UserStatus::BLOCK) {
            return $this->response([
                "message" => "Your account is blocked"
            ], StatusResponse::BLOCKED_ACCOUNT);
        }

        return $this->response([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ], StatusResponse::SUCCESS);
    }

    public function activeAccount($input)
    {
        $email = $input['email'];
        $verify_code = $input['verify_code'];

        $user = User::where('email', $email)
            ->where('status', UserStatus::DEACTIVE)
            ->first();

        $result = $this->checkVerifyAccount($user, $verify_code);
        
        if ($result) {
            return $result;
        }

        $user->status = UserStatus::ACTIVE;
        $user->accountVerify->delete();
        $user->save();

        return $this->response([
            'message' => 'Activate account successfully'
        ], StatusResponse::SUCCESS);
    }

    public function resetPassword($input)
    {
        $verify_code = $input['verify_code'];
        $newPassword = $input['new_password'];

        $accountVerify = AccountVerify::where('verify_code', $verify_code)->first();

        if(!$accountVerify) {
            return $this->response([
                'message' => 'Can not find out this verify code'
            ], StatusResponse::ERROR);
        }

        $user = $accountVerify->user;

        $result = $this->checkVerifyAccount($user, $verify_code);

        if ($result) {
            return $result;
        }

        $user->password = bcrypt($newPassword);
        $user->accountVerify->delete();
        $user->save();

        return $this->response([
            'message' => 'Change password successfully'
        ], StatusResponse::SUCCESS);
    }

    private function checkVerifyAccount($user, $verify_code)
    {
        if (!$user) {
            return $this->response([
                'message' => 'Can not find user or user is already active'
            ], StatusResponse::ERROR);
        }

        $accountVerify = $user->accountVerify;

        if (!$accountVerify or $accountVerify->overtimed_at < now() or $accountVerify->verify_code != $verify_code) {
            return $this->response([
                'message' => 'Your verify code is invalid'
            ], StatusResponse::ERROR);
        }

        return null;
    }
}