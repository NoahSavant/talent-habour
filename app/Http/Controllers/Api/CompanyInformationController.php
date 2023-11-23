<?php

namespace App\Http\Controllers\Api;

use App\Constants\AuthenConstant\StatusResponse;
use App\Constants\UserConstant\UserRole;
use App\Http\Controllers\Controller;
use App\Models\CompanyInformation;
use App\Services\ModelServices\CompanyInformationService;
use App\Services\ModelServices\UserService;
use Illuminate\Http\Request;

class CompanyInformationController extends Controller
{
    protected $companyInformationService;

    public function __construct(CompanyInformationService $companyInformationService) {
        $this->companyInformationService = $companyInformationService;
    }

    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return response()->json(auth()->user()->companyInformation, StatusResponse::SUCCESS);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $result = $this->companyInformationService->update(auth()->user()->id, $request->all());

        if ($result) {
            return response()->json($result, StatusResponse::SUCCESS);
        }

        return response()->json([
            'message' => 'Update comapny information fail'
        ], StatusResponse::ERROR);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getListCompanies(Request $request)
    {
        $result = $this->companyInformationService->getListCompanies($request->all());

        if ($result) {
            return response()->json($result, StatusResponse::SUCCESS);
        }

        return response()->json([
            'message' => 'Get list companies fail',
        ], StatusResponse::ERROR);
    }

    public function getCompany(string $id)
    {
        $result = $this->companyInformationService->getCompany($id);

        if ($result) {
            return response()->json($result, StatusResponse::SUCCESS);
        }

        return response()->json([
            'message' => 'Get company fail',
        ], StatusResponse::ERROR);
    }
}
