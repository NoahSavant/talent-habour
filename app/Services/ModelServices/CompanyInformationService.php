<?php 

namespace App\Services\ModelServices;
use App\Constants\UserConstant\UserRole;
use App\Constants\UserConstant\UserStatus;
use App\Models\CompanyInformation;
use App\Models\User;

class CompanyInformationService extends BaseService {
    public function __construct(CompanyInformation $companyInformation) {
        $this->model = $companyInformation;
    }
}