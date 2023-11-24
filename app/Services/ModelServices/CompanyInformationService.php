<?php 

namespace App\Services\ModelServices;
use App\Http\Resources\CompanyResource;
use App\Models\CompanyInformation;

class CompanyInformationService extends BaseService {
    public function __construct(CompanyInformation $companyInformation) {
        $this->model = $companyInformation;
    }

    public function getListCompanies($input) {
        $search = $input['$search'] ?? '';

        $query = $this->model->search($search);
        $data = $this->getAll($input, $query);
        $data['items'] = CompanyResource::collection($data['items']);
        return $data;
    }

    public function getCompany($id) {
        $company = $this->model->where('id', $id)->first();

        if(!$company) return false;

        return [
            'company' => $company,
            'recruitment_posts' =>  $company->user->recrumentPosts
        ];
    }
}