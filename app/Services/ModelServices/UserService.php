<?php 

namespace App\Services\ModelServices;
use App\Constants\UserConstant\UserRole;
use App\Constants\UserConstant\UserStatus;
use App\Models\User;

class UserService extends BaseService {

    protected $accountVerifyService;
    protected $applicationService;
    protected $companyInformationService;
    protected $recruitmentPostService;
    protected $resumeService;

    public function __construct(
        User $user, 
        AccountVerifyService $accountVerifyService,
        ApplicationService $applicationService,
        CompanyInformationService $companyInformationService,
        RecruitmentPostService $recruitmentPostService,
        ResumeService $resumeService
    ) {
        $this->model = $user;
        $this->accountVerifyService = $accountVerifyService;
        $this->applicationService = $applicationService;
        $this->companyInformationService = $companyInformationService;
        $this->recruitmentPostService = $recruitmentPostService;
        $this->resumeService = $resumeService;
    }

    public function getAllUser() {
        $users = User::whereNot('role', UserRole::ADMIN)->get();
        return $users;
    }

    public function isEmailExist($email)
    {
        return User::where('email', $email)->where('status', UserStatus::ACTIVE)->exists();
    }

    public function updateProfile($input)
    {
        $user = auth()->user();
        $result = $user->update($this->getValue($input, [
            'first_name',
            'last_name',
            'gender',
            'date_of_birth',
            'phonenumber',
            'introduction',
            'image_url'
        ]));

        if (!$result) return false;
        
        return $user;
    }

    public function delete($ids) {
        $users = $this->model->whereIn('id', $ids)->get();

        foreach($users as $user) {
            if($user->role === UserRole::RECRUITER) {
                $this->companyInformationService->delete([$user->companyInformation->id]);
                $this->recruitmentPostService->delete($this->getColumn($user->recruitmentPosts));
            } else {
                $this->resumeService->delete($this->getColumn($user->resumes));
                $this->applicationService->delete($this->getColumn($user->applications));
            }
        }

        return parent::delete($ids);
    }
}