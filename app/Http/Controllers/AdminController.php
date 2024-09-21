<?php

namespace App\Http\Controllers;

use App\Http\Resources\Admin\AdminUserResource;
use App\Models\Enums\ProductApprovalStatus;
use App\Services\AdminUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AdminController extends Controller
{

    private AdminUserService $adminUserService;

    /**
     * @param AdminUserService $adminUserService
     */
    public function __construct(AdminUserService $adminUserService)
    {
        $this->adminUserService = $adminUserService;
    }

    /**
     * Display all admins within the system.
     */
    public function index(): AnonymousResourceCollection
    {
        return AdminUserResource::collection($this->adminUserService->getAllAdmin());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $user_id): AdminUserResource
    {
        return new AdminUserResource($this->adminUserService->makeUserAdmin($user_id, $request->user()));
    }

    /**
     * Display the specified admin
     */
    public function show(string $id): AdminUserResource
    {
        return new AdminUserResource($this->adminUserService->getAdminById($id));
    }

    /**
     * Revoke user Admin Privilege.
     */
    public function destroy(string $id): JsonResponse
    {
        if ($this->adminUserService->revokeAdminPrivilege($id))
            return response()->json(["message" => "Successful"]);
        return response(status: ResponseAlias::HTTP_BAD_REQUEST)->json(["message" => "failed"]);
    }

    /**
     * Activate System User
     * @param Request $request
     * @return JsonResponse
     */
    public function activateSystemUser(Request $request): JsonResponse
    {
        $validate = $request->validate([
            'password'      => 'required|string|min:8'
        ]);

        if ($this->adminUserService->activateSystemUser($validate, $request->user()))
            return response()->json(['message' => 'System User Activation Successful']);
        return response(status: ResponseAlias::HTTP_PRECONDITION_FAILED)->json(['message' => 'System User Activation Failed']);


    }

    //-------------------- Definition of main Admin Operations-------------------------------------
    // 1.) Approve Product

    /**
     * Approve or Reject Product
     * @param Request $request
     * @param $product
     * @return true
     */
    public function approveProduct(Request $request, $product): true
    {
        $validated = $request->validate([
            'approval_comment' => ['string', 'required_if:approval,REJECTED'],
            'approval'  => ['required', Rule::enum(ProductApprovalStatus::class)->only([ProductApprovalStatus::APPROVED, ProductApprovalStatus::REJECTED])]
        ]);

        return $this->adminUserService->setProductApproval($product, $validated, $request->user());
    }
}
