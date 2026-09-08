<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display projects.
     */
    public function index(Request $request): View
    {
        $projects = Project::query()
            ->with([
                'incomingEntity',
                'contractor',
                'pricingItems',
            ])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view(
            'projects.index',
            compact('projects')
        );
    }

    /**
     * Show create project page.
     */
    public function create(): View
    {
        return view('projects.create');
    }

    /**
     * Store project.
     */
    public function store(
        CreateProjectRequest $request
    ): RedirectResponse {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $project = Project::create([
                'name' => $data['name'],
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
                        'quantity' => $item['quantity'],
                        'unit_price_syp' =>
                            $item['unit_price_syp'],
                        'unit_price_usd' =>
                            $item['unit_price_usd'],
                        'specifications' =>
                            isset($item['specifications'])
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

        return redirect()
            ->route('projects.index')
            ->with('success', 'تم إنشاء المشروع بنجاح.');
    }

    /**
     * Display project.
     */
    public function show(Project $project): View
    {
        $project->load([
            'incomingEntity',
            'contractor',
            'pricingItems',
        ]);

        return view(
            'projects.show',
            compact('project')
        );
    }

    /**
     * Show edit project page.
     */
    public function edit(Project $project): View
    {
        $project->load([
            'incomingEntity',
            'contractor',
            'pricingItems',
        ]);

        return view(
            'projects.edit',
            compact('project')
        );
    }

    /**
     * Update project.
     */
    public function update(
        UpdateProjectRequest $request,
        Project $project
    ): RedirectResponse {
        $data = $request->validated();

        DB::transaction(function () use ($data, $project) {
            $updateData = [];

            if (array_key_exists('name', $data)) {
                $updateData['name'] = $data['name'];
            }

            if (array_key_exists('signing_location', $data)) {
                $updateData['signing_location'] =
                    $data['signing_location'];
            }

            if (array_key_exists('start_date', $data)) {
                $updateData['start_date'] =
                    $data['start_date'];
            }

            if (array_key_exists('end_date', $data)) {
                $updateData['end_date'] =
                    $data['end_date'];
            }

            if (array_key_exists('incoming_entity_id', $data)) {
                $updateData['incoming_entity_id'] =
                    $data['incoming_entity_id'];
            }

            if (array_key_exists('contractor_id', $data)) {
                $updateData['contractor_id'] =
                    $data['contractor_id'];
            }

            if (!empty($updateData)) {
                $project->update($updateData);
            }

            if (array_key_exists('pricing_items', $data)) {
                $pricingItems = [];

                foreach ($data['pricing_items'] as $item) {
                    $pricingItems[
                        $item['pricing_item_id']
                    ] = [
                        'quantity' => $item['quantity'],
                        'unit_price_syp' =>
                            $item['unit_price_syp'],
                        'unit_price_usd' =>
                            $item['unit_price_usd'],
                        'specifications' =>
                            isset($item['specifications'])
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

        return redirect()
            ->route('projects.index')
            ->with('success', 'تم تعديل المشروع بنجاح.');
    }

    /**
     * Delete project.
     */
    public function destroy(
        Project $project
    ): RedirectResponse {
        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'تم حذف المشروع بنجاح.');
    }
}