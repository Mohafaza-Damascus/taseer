<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Responses\ApiResponse;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * عرض المشاريع
     */
    public function index(Request $request): JsonResponse
    {
        $projects = Project::query()
            ->with([
                'incomingEntity',
                'contractor',
                'pricingItems',
            ])
            ->latest()
            ->paginate(
                $request->integer('per_page', 15)
            );

        return ApiResponse::success(
            'تم جلب المشاريع بنجاح.',
            [
                'projects' => ProjectResource::collection(
                    $projects->items()
                ),

                'pagination' => [
                    'current_page' =>
                        $projects->currentPage(),

                    'last_page' =>
                        $projects->lastPage(),

                    'per_page' =>
                        $projects->perPage(),

                    'total' =>
                        $projects->total(),
                ],
            ]
        );
    }

    /**
     * إنشاء مشروع
     */
    public function store(
        CreateProjectRequest $request
    ): JsonResponse {
        $data = $request->validated();

        $project = DB::transaction(function () use ($data) {

            $project = Project::create([
                'name' =>
                    $data['name'],

                'signing_location' =>
                    $data['signing_location'] ?? null,

                'start_date' =>
                    $data['start_date'] ?? null,

                'end_date' =>
                    $data['end_date'] ?? null,

                'incoming_entity_id' =>
                    $data['incoming_entity_id'] ?? null,

                'contractor_id' =>
                    $data['contractor_id'] ?? null,
            ]);

            if (!empty($data['pricing_items'])) {

                $pricingItems = [];

                foreach ($data['pricing_items'] as $item) {

                    $pricingItems[
                        $item['pricing_item_id']
                    ] = [
                        'quantity' =>
                            $item['quantity'],

                        'unit_price_syp' =>
                            $item['unit_price_syp'],

                        'unit_price_usd' =>
                            $item['unit_price_usd'],

                        'specifications' => isset($item['specifications'])
                            ? json_encode(
                                $item['specifications'],
                                JSON_UNESCAPED_UNICODE
                            )
                            : null,
                    ];
                }

                $project->pricingItems()->sync(
                    $pricingItems
                );
            }

            return $project;
        });

        $project->load([
            'incomingEntity',
            'contractor',
            'pricingItems',
        ]);

        return ApiResponse::success(
            'تم إنشاء المشروع بنجاح.',
            [
                'project' => new ProjectResource($project),
            ],
            201
        );
    }

    /**
     * عرض مشروع واحد
     */
    public function show(Project $project): JsonResponse
    {
        $project->load([
            'incomingEntity',
            'contractor',
            'pricingItems',
        ]);

        return ApiResponse::success(
            'تم جلب بيانات المشروع بنجاح.',
            [
                'project' =>
                    new ProjectResource($project),
            ]
        );
    }

    /**
     * تعديل مشروع
     */
    public function update(
        UpdateProjectRequest $request,
        Project $project
    ): JsonResponse {
        $data = $request->validated();

        DB::transaction(function () use ($data, $project) {

            $updateData = [];

            if (array_key_exists('name', $data)) {
                $updateData['name'] =
                    $data['name'];
            }

            if (
                array_key_exists(
                    'signing_location',
                    $data
                )
            ) {
                $updateData['signing_location'] =
                    $data['signing_location'];
            }

            if (
                array_key_exists(
                    'start_date',
                    $data
                )
            ) {
                $updateData['start_date'] =
                    $data['start_date'];
            }

            if (
                array_key_exists(
                    'end_date',
                    $data
                )
            ) {
                $updateData['end_date'] =
                    $data['end_date'];
            }

            if (
                array_key_exists(
                    'incoming_entity_id',
                    $data
                )
            ) {
                $updateData['incoming_entity_id'] =
                    $data['incoming_entity_id'];
            }

            if (
                array_key_exists(
                    'contractor_id',
                    $data
                )
            ) {
                $updateData['contractor_id'] =
                    $data['contractor_id'];
            }

            if (!empty($updateData)) {
                $project->update($updateData);
            }

            /*
             * فقط إذا تم إرسال pricing_items
             * نقوم بتحديث البنود.
             */
            if (
                array_key_exists(
                    'pricing_items',
                    $data
                )
            ) {

                $pricingItems = [];

                foreach (
                    $data['pricing_items']
                    as $item
                ) {

                    $pricingItems[
                        $item['pricing_item_id']
                    ] = [
                        'quantity' =>
                            $item['quantity'],

                        'unit_price_syp' =>
                            $item['unit_price_syp'],

                        'unit_price_usd' =>
                            $item['unit_price_usd'],

                        'specifications' => isset($item['specifications'])
                            ? json_encode(
                                $item['specifications'],
                                JSON_UNESCAPED_UNICODE
                            )
                            : null,
                    ];
                }

                $project->pricingItems()->sync(
                    $pricingItems
                );
            }
        });

        $project->load([
            'incomingEntity',
            'contractor',
            'pricingItems',
        ]);

        return ApiResponse::success(
            'تم تعديل المشروع بنجاح.',
            [
                'project' =>
                    new ProjectResource($project),
            ]
        );
    }

    /**
     * حذف مشروع
     */
    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return ApiResponse::success(
            'تم حذف المشروع بنجاح.'
        );
    }
}