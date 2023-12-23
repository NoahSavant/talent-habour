<?php

namespace App\Services\ModelServices;

use App\Models\Resume;

class ResumeService extends BaseService
{
    public function __construct(Resume $resume)
    {
        $this->model = $resume;
    }

    public function get($input)
    {
        $search = $input['search'] ?? '';
        $user = auth()->user();
        $query = $this->model->where('user_id', $user->id)->search($search);
        $data = $this->getAll($input, $query);

        return $data;
    }

    public function show($id)
    {
        return $this->model->where('user_id', auth()->user()->id)->where('id', $id)->first();
    }
}
