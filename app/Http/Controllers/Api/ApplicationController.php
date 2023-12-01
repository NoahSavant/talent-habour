<?php

namespace App\Http\Controllers\Api;

use App\Constants\AuthenConstant\StatusResponse;
use App\Constants\UserConstant\UserRole;
use App\Http\Controllers\Controller;
use App\Services\ModelServices\ApplicationService;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    protected $applicationService;

    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function index(Request $request)
    {
        return response()->json($this->applicationService->get($request->all()), StatusResponse::SUCCESS);
    }

    public function getByPost(string $id, Request $request) {
        return response()->json($this->applicationService->getByPost($id, $request->all()), StatusResponse::SUCCESS);
    }

    public function store(Request $request)
    {
        $result = $this->applicationService->create($request->all());

        if ($result) {
            return response()->json($result, StatusResponse::SUCCESS);
        }

        return response()->json([
            'message' => 'Apply fail',
        ], StatusResponse::ERROR);
    }

    public function show(string $id)
    {
        $result = $this->applicationService->show($id);

        if ($result) {
            return response()->json($result, StatusResponse::SUCCESS);
        }

        return response()->json([
            'message' => 'Can not findout this application',
        ], StatusResponse::ERROR);
    }

    public function update(string $id, Request $request)
    {
        $result = $this->applicationService->update($id, $request->all());

        if ($result) {
            return response()->json($result, StatusResponse::SUCCESS);
        }

        return response()->json([
            'message' => 'Update application fail',
        ], StatusResponse::ERROR);
    }

    public function delete(Request $request)
    {
        $result = $this->applicationService->delete($request->get('ids'));

        if ($result) {
            return response()->json([
                'message' => 'Delete application successfully',
            ], StatusResponse::SUCCESS);
        }

        return response()->json([
            'message' => 'Delete application fail',
        ], StatusResponse::ERROR);
    }
}
