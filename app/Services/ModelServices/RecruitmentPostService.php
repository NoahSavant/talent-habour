<?php 

namespace App\Services\ModelServices;
use App\Constants\UserConstant\UserRole;
use App\Constants\UserConstant\UserStatus;
use App\Http\Resources\RecruitmentPostResource;
use App\Models\RecruitmentPost;

class RecruitmentPostService extends BaseService {
    public function __construct(RecruitmentPost $recruitmentPost) {
        $this->model = $recruitmentPost;
    }

    public function store($input) {
        $result = $this->create(array_merge($input, [
            'user_id' => auth()->user()->id
        ]));

        return $result;
    }

    public function update($id, $input)
    {
        $recruitmentPost = $this->model->where('id', $id)->where('user_id', auth()->user()->id)->first();

        if(!$recruitmentPost) return false;

        $result = $recruitmentPost->update($this->getValue($input, [
            'role',
            'title',
            'address',
            'job_type',
            'salary',
            'description',
            'job_requirements',
            'educational_requirements',
            'experience_requirements',
            'expired_at',
        ]));

        if (!$result)
            return false;

        return $recruitmentPost;
    }

    public function getRecruitmentPosts($input)
    {
        $types = $input["types"] ?? [];
        $experiences = $input["experiences"] ?? [];
        $date = $input['date'] ?? null;
        $search = $input['$search'] ?? '';

        $query = $this->model->experiencesFillter($experiences)->typesFillter($types)->updatedAfter($date)->search($search);
        $data = $this->getAll($input, $query);
        $data['items'] = RecruitmentPostResource::collection($data['items']);
        return $data;
    }

    public function getPersonalRecruitmentPosts($input)
    {
        $types = $input["types"] ?? [];
        $experiences = $input["experiences"] ?? [];
        $date = $input['date'] ?? null;
        $search = $input['$search'] ?? '';

        $query = $this->model->where('user_id', auth()->user()->id)->experiencesFillter($experiences)->typesFillter($types)->updatedAfter($date)->search($search);
        $data = $this->getAll($input, $query);
        $data['items'] = RecruitmentPostResource::collection($data['items']);
        return $data;
    }

    public function show($id) {
        $result = $this->model->where('id', $id)->first();

        if(!$result) return false;

        return $result;
    }
}