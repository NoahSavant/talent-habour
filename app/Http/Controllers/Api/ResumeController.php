<?php

namespace App\Http\Controllers\Api;

use App\Constants\AuthenConstant\StatusResponse;
use App\Http\Controllers\Controller;
use App\Services\ModelServices\ResumeService;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    protected $resumeService;

    public function __construct(ResumeService $resumeService) {
        $this->resumeService = $resumeService;
    }

    public function index(Request $request) {
        return response()->json($this->resumeService->get($request->all()), StatusResponse::SUCCESS);
    }

    public function store(Request $request) {
        $result = $this->resumeService->create(array_merge($request->all(), [
            'user_id' => auth()->user()->id
        ]));

        if ($result) {
            return response()->json($result, StatusResponse::SUCCESS);
        }

        return response()->json([
            'message' => 'Create resume fail',
        ], StatusResponse::ERROR);
    }

    public function show(string $id) {
        $result = $this->resumeService->show($id);

        if ($result) {
            return response()->json($result, StatusResponse::SUCCESS);
        }

        return response()->json([
            'message' => 'Can not findout this resume',
        ], StatusResponse::ERROR);
    }

    public function update(string $id, Request $request) {
        $result = $this->resumeService->update($id, $request->all());

        if ($result) {
            return response()->json($result, StatusResponse::SUCCESS);
        }

        return response()->json([
            'message' => 'Update resume fail',
        ], StatusResponse::ERROR);
    }

    public function delete(Request $request) {
        $result = $this->resumeService->delete($request->get('ids'));

        if ($result) {
            return response()->json([
                'message' => 'Delete resume successfully',
            ], StatusResponse::SUCCESS);
        }

        return response()->json([
            'message' => 'Delete resume fail',
        ], StatusResponse::ERROR);
    }
}
