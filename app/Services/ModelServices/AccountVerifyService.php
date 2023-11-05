<?php 

namespace App\Services\ModelServices;
use App\Models\AccountVerify;

class AccountVerifyService extends BaseService {
    public function __construct(AccountVerify $accountVerify) {
        $this->model = $accountVerify;
    }
}