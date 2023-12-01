<?php

namespace App\Http\Controllers\Api;

use App\Constants\AuthenConstant\StatusResponse;
use App\Http\Controllers\Controller;
use App\Services\ModelServices\RecruitmentPostService;
use Illuminate\Http\Request;

class RecruitmentPostController extends Controller
{
    protected $recruitmentPostService;

    public function __construct(RecruitmentPostService $recruitmentPostService) {
        $this->recruitmentPostService = $recruitmentPostService;
    }

    public function index(Request $request) 
    {
        return response()->json($this->recruitmentPostService->getRecruitmentPosts($request->all()), StatusResponse::SUCCESS);
    }

    public function getPersonalPosts(Request $request)
    {
        return response()->json($this->recruitmentPostService->getPersonalRecruitmentPosts($request->all()), StatusResponse::SUCCESS);
    }

    public function store(Request $request) {
        $result = $this->recruitmentPostService->store($request->all());

        if ($result) {
            return response()->json($result, StatusResponse::SUCCESS);
        }

        return response()->json([
            'message' => 'Create recruitment post fail',
        ], StatusResponse::ERROR);
    }

    public function update(Request $request, string $id)
    {
        $result = $this->recruitmentPostService->update($id, $request->all());

        if($result) {
            return response()->json($result, StatusResponse::SUCCESS);
        }

        return response()->json([
            'message' => 'Update recruitment post fail',
        ], StatusResponse::ERROR);
    }

    public function show(string $id) {
        $result = $this->recruitmentPostService->show($id);

        if ($result) {
            return response()->json($result, StatusResponse::SUCCESS);
        }

        return response()->json([
            'message' => 'Get recruitment post fail',
        ], StatusResponse::ERROR);
    }

    public function delete(Request $request)
    {
        $result = $this->recruitmentPostService->delete($request->get('ids') ?? []);

        if ($result) {
            return response()->json([
                'message' => 'Delete comapny information successfully'
            ], StatusResponse::SUCCESS);
        }

        return response()->json([
            'message' => 'Delete comapny information fail'
        ], StatusResponse::ERROR);
    }
}
