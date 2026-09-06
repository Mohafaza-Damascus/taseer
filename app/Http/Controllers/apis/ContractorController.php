<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contractor\CreateContractorRequest;
use App\Http\Requests\Contractor\UpdateContractorRequest;
use App\Http\Resources\ContractorResource;
use App\Http\Responses\ApiResponse;
use App\Models\Contractor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContractorController extends Controller
{
    /**
     * Display a listing of contractors.
     */
    public function index(Request $request): JsonResponse
    {
        $contractors = Contractor::query()
            ->latest()
            ->paginate(
                $request->integer('per_page', 15)
            );

        return ApiResponse::success(
            'تم جلب المتعهدين بنجاح.',
            [
                'contractors' => ContractorResource::collection(
                    $contractors->items()
                ),

                'pagination' => [
                    'current_page' =>
                        $contractors->currentPage(),

                    'last_page' =>
                        $contractors->lastPage(),

                    'per_page' =>
                        $contractors->perPage(),

                    'total' =>
                        $contractors->total(),
                ],
            ]
        );
    }

    /**
     * Store a newly created contractor.
     */
    public function store(
        CreateContractorRequest $request
    ): JsonResponse {
        $data = $request->validated();

        $contractor = Contractor::create([
            'name' =>
                $data['name'],

            'phone' =>
                $data['phone'],

            'national_number' =>
                $data['national_number'],

            'company_name' =>
                $data['company_name'] ?? null,
        ]);

        return ApiResponse::success(
            'تم إنشاء المتعهد بنجاح.',
            [
                'contractor' =>
                    new ContractorResource($contractor),
            ],
            201
        );
    }

    /**
     * Display the specified contractor.
     */
    public function show(
        Contractor $contractor
    ): JsonResponse {
        $contractor->load('projects');

        return ApiResponse::success(
            'تم جلب بيانات المتعهد بنجاح.',
            [
                'contractor' =>
                    new ContractorResource($contractor),
            ]
        );
    }

    /**
     * Update the specified contractor.
     */
    public function update(
        UpdateContractorRequest $request,
        Contractor $contractor
    ): JsonResponse {
        $data = $request->validated();

        $updateData = [];

        if (array_key_exists('name', $data)) {
            $updateData['name'] =
                $data['name'];
        }

        if (array_key_exists('phone', $data)) {
            $updateData['phone'] =
                $data['phone'];
        }

        if (
            array_key_exists(
                'national_number',
                $data
            )
        ) {
            $updateData['national_number'] =
                $data['national_number'];
        }

        if (
            array_key_exists(
                'company_name',
                $data
            )
        ) {
            $updateData['company_name'] =
                $data['company_name'];
        }

        if (!empty($updateData)) {
            $contractor->update($updateData);
        }

        $contractor->load('projects');

        return ApiResponse::success(
            'تم تعديل المتعهد بنجاح.',
            [
                'contractor' =>
                    new ContractorResource($contractor),
            ]
        );
    }

    /**
     * Remove the specified contractor.
     */
    public function destroy(
        Contractor $contractor
    ): JsonResponse {
        /*
         * المتعهد مرتبط بمشاريع.
         * إذا كان هناك مشاريع مرتبطة به،
         * لا نحذف المتعهد حتى لا نفقد العلاقة.
         */
        if ($contractor->projects()->exists()) {
            return ApiResponse::error(
                'لا يمكن حذف المتعهد لأنه مرتبط بمشروع أو أكثر.',
                null,
                422
            );
        }

        $contractor->delete();

        return ApiResponse::success(
            'تم حذف المتعهد بنجاح.'
        );
    }
}