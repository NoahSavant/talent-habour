<?php 

namespace App\Services\ModelServices;
use App\Http\Resources\EmployeeApplicationResource;
use App\Http\Resources\RecruiterApplicationResource;
use App\Models\Application;

class ApplicationService extends BaseService {
    public function __construct(Application $application) {
        $this->model = $application;
    }

    public function get($input)
    {
        $search = $input['$search'] ?? '';
        $user = auth()->user();
        $query = $this->model->with(['recruitmentPost' => [
            'user' => [
                'companyInformation'
            ]
        ]])->where('user_id', $user->id)->search($search);
        $data = $this->getAll($input, $query);
        $data['items'] = EmployeeApplicationResource::collection($data['items']);
        return $data;
    }

    public function getByPost($postId, $input) {
        $search = $input['$search'] ?? '';

        $query = $this->model->with(['user'])->where('recruitment_post_id', $postId)->search($search);
        $data = $this->getAll($input, $query);
        $data['items'] = RecruiterApplicationResource::collection($data['items']);
        return $data;
    }

    public function show($id)
    {
        return $this->model->where('id', $id)->first();
    }
}