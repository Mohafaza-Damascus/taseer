<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Contractor;
use App\Models\IncomingEntity;
use App\Models\PricingItem;
use App\Models\RelatedWork;
use App\Models\Project;
use App\Models\ProjectPricingItem;
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
        $incomingEntities = IncomingEntity::query()->orderBy('name')->get();
        $contractors = Contractor::query()->orderBy('name')->get();
        $sort = $request->input('sort', 'name');
        $projects = Project::query()
            ->with(['incomingEntity', 'contractor'])
            ->withCount('pricingItems')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('search') . '%');
            })
            ->when($request->filled('entity'), function ($query) use ($request) {
                $query->where('incoming_entity_id', $request->input('entity'));
            })
            ->when($request->filled('contractor'), function ($query) use ($request) {
                $query->where('contractor_id', $request->input('contractor'));
            })
            ->when($request->filled('dateFrom'), function ($query) use ($request) {
                $query->whereDate('start_date', '>=', $request->input('dateFrom'));
            })
            ->when($request->filled('dateTo'), function ($query) use ($request) {
                $query->whereDate('start_date', '<=', $request->input('dateTo'));
            });

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        switch ($sort) {
            case 'startDate':
                $projects->orderBy('start_date', 'desc');
                break;

            case 'itemsCount':
                $projects->orderBy('pricing_items_count', 'desc');
                break;

            case 'totalSYP':
                $projects->orderByDesc(ProjectPricingItem::query()->selectRaw('COALESCE(SUM(quantity * unit_price_syp), 0)')->whereColumn('project_pricing_items.project_id', 'projects.id'));
                break;

            case 'name':
            default:
                $projects->orderBy('name');
                break;
        }
        $projects = $projects->paginate(15)->withQueryString();

        return view('projects.index', compact('projects', 'incomingEntities', 'contractors'));
    }

    /**
     * Show create project page.
     */
    public function create(): View
    {
        $incomingEntities = IncomingEntity::query()->orderBy('name')->get();

        $contractors = Contractor::query()->orderBy('name')->get();

        $pricingItems = PricingItem::query()
            ->with(['relatedWork', 'specifications'])
            ->orderBy('name')
            ->get();

        $relatedWorks = RelatedWork::query()->orderBy('name')->get();

        return view(
            'projects.create',
            compact(
                'incomingEntities',
                'contractors',
                'pricingItems',
                'relatedWorks'
            )
        );
    }

    /**
     * Store project.
     */

    public function store(CreateProjectRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {

            $incomingEntityId = $data['incoming_entity_id'] ?? null;
            if (!$incomingEntityId && !empty($data['new_incoming_entity_name'])) {
                $incomingEntityId = IncomingEntity::create([
                    'name'  => $data['new_incoming_entity_name'],
                    'notes' => $data['new_incoming_entity_notes'] ?? null,
                ])->id;
            }

            $contractorId = $data['contractor_id'] ?? null;
            if (!$contractorId && !empty($data['new_contractor_name'])) {
                $contractorId = Contractor::create([
                    'name'            => $data['new_contractor_name'],
                    'phone'           => $data['new_contractor_phone'],
                    'national_number' => $data['new_contractor_national_number'],
                    'company_name'    => $data['new_contractor_company_name'] ?? null,
                ])->id;
            }

            $project = Project::create([
                'name'               => $data['name'],
                'signing_location'   => $data['signing_location'] ?? null,
                'start_date'         => $data['start_date'] ?? null,
                'end_date'           => $data['end_date'] ?? null,
                'incoming_entity_id' => $incomingEntityId,
                'contractor_id'      => $contractorId,
            ]);

            if (!empty($data['pricing_items'])) {

                $syncData = [];

                foreach ($data['pricing_items'] as $item) {

                    $pricingItemId = $item['pricing_item_id'] ?? null;

                    if (!$pricingItemId && !empty($item['new_item_name'])) {

                        $relatedWorkId = $item['new_item_related_work_id'] ?? null;
                        if (!$relatedWorkId && !empty($item['new_item_related_work_name'])) {
                            $relatedWorkId = RelatedWork::create([
                                'name' => $item['new_item_related_work_name'],
                            ])->id;
                        }

                        $pricingItem = PricingItem::create([
                            'name'            => $item['new_item_name'],
                            'unit'            => $item['new_item_unit'] ?? null,
                            'related_work_id' => $relatedWorkId,
                        ]);

                        if (!empty($item['specifications'])) {
                            foreach ($item['specifications'] as $spec) {
                                if (trim((string) $spec) === '') continue;
                                $pricingItem->specifications()->create([
                                    'name' => $spec,
                                ]);
                            }
                        }

                        $pricingItemId = $pricingItem->id;
                    }

                    if (!$pricingItemId) {
                        continue;
                    }

                    $syncData[$pricingItemId] = [
                        'quantity'       => $item['quantity'],
                        'unit_price_syp' => $item['unit_price_syp'],
                        'unit_price_usd' => $item['unit_price_usd'],
                        'specifications' =>
                            isset($item['specifications'])
                                ? json_encode($item['specifications'], JSON_UNESCAPED_UNICODE)
                                : null,
                    ];
                }

                $project->pricingItems()->sync($syncData);
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
        $project->load(['incomingEntity', 'contractor', 'pricingItems.relatedWork']);

        $incomingEntities = IncomingEntity::query()->orderBy('name')->get();

        $contractors = Contractor::query()->orderBy('name')->get();

        $pricingItems = PricingItem::query()
            ->with(['relatedWork', 'specifications'])
            ->orderBy('name')
            ->get();

        return view('projects.show', compact('project', 'incomingEntities', 'contractors', 'pricingItems'));
    }

    /**
     * Show edit project page.
     */
    public function edit(Project $project): View
    {
        $project->load(['incomingEntity', 'contractor', 'pricingItems.relatedWork']);

        $incomingEntities = \App\Models\IncomingEntity::query()->orderBy('name')->get();

        $contractors = \App\Models\Contractor::query()->orderBy('name')->get();

        $pricingItems = \App\Models\PricingItem::query()
            ->with(['relatedWork', 'specifications'])
            ->orderBy('name')
            ->get();

        $pricingItemsData = $pricingItems
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'unit' => $item->unit,
                    'related_work' => $item->relatedWork?->name,
                    'specifications' => $item->specifications->pluck('name')->values()->toArray(),
                ];
            })
            ->values();

        return view('projects.edit', compact('project', 'incomingEntities', 'contractors', 'pricingItems', 'pricingItemsData'));
    }
    /**
     * Update project.
     */
    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $project) {
            $updateData = [];

            if (array_key_exists('name', $data)) {
                $updateData['name'] = $data['name'];
            }

            if (array_key_exists('signing_location', $data)) {
                $updateData['signing_location'] = $data['signing_location'];
            }

            if (array_key_exists('start_date', $data)) {
                $updateData['start_date'] = $data['start_date'];
            }

            if (array_key_exists('end_date', $data)) {
                $updateData['end_date'] = $data['end_date'];
            }

            if (array_key_exists('incoming_entity_id', $data)) {
                $updateData['incoming_entity_id'] = $data['incoming_entity_id'];
            }

            if (array_key_exists('contractor_id', $data)) {
                $updateData['contractor_id'] = $data['contractor_id'];
            }

            if (!empty($updateData)) {
                $project->update($updateData);
            }

            if (array_key_exists('pricing_items', $data)) {
                $pricingItems = [];

                foreach ($data['pricing_items'] as $item) {
                    $pricingItems[$item['pricing_item_id']] = [
                        'quantity' => $item['quantity'],
                        'unit_price_syp' => $item['unit_price_syp'],
                        'unit_price_usd' => $item['unit_price_usd'],
                        'specifications' => isset($item['specifications']) ? json_encode($item['specifications'], JSON_UNESCAPED_UNICODE) : null,
                    ];
                }

                $project->pricingItems()->sync($pricingItems);
            }
        });

        return redirect()->route('projects.index')->with('success', 'تم تعديل المشروع بنجاح.');
    }

    /**
     * Delete project.
     */
    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'تم حذف المشروع بنجاح.');
    }
}
