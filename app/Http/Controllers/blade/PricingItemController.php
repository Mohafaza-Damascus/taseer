<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Http\Requests\PricingItem\CreatePricingItemRequest;
use App\Http\Requests\PricingItem\UpdatePricingItemRequest;
use App\Models\PricingItem;
use App\Models\RelatedWork;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class PricingItemController extends Controller
{
    public function index(Request $request): View
    {
        $pricingItems = PricingItem::query()
            ->with('relatedWork')
            ->withCount('specifications')
            ->latest()
            ->paginate(15);

        return view(
            'pricing_items.index',
            compact('pricingItems')
        );
    }

    public function create(): View
    {
        $relatedWorks = RelatedWork::query()
            ->orderBy('name')
            ->get();

        return view(
            'pricing_items.create',
            compact('relatedWorks')
        );
    }

    public function store(
        CreatePricingItemRequest $request
    ): RedirectResponse {
        DB::transaction(function () use ($request) {

            $data = $request->validated();

            $specifications = $data['specifications'] ?? [];

            unset($data['specifications']);

            $pricingItem = PricingItem::create($data);

            foreach ($specifications as $specification) {

                if (blank($specification)) {
                    continue;
                }

                $pricingItem->specifications()->create([
                    'name' => $specification,
                ]);
            }
        });

        return redirect()
            ->route('pricing-items.index')
            ->with(
                'success',
                'تم إنشاء بند التسعير بنجاح.'
            );
    }

    public function show(
        PricingItem $pricingItem
    ): View {
        $pricingItem->load([
            'relatedWork',
            'specifications',
            'projects',
        ]);

        return view(
            'pricing_items.show',
            compact('pricingItem')
        );
    }

    public function edit(
        PricingItem $pricingItem
    ): View {
        $pricingItem->load('specifications');

        $relatedWorks = RelatedWork::query()
            ->orderBy('name')
            ->get();

        return view(
            'pricing_items.edit',
            compact(
                'pricingItem',
                'relatedWorks'
            )
        );
    }

    public function update(
        UpdatePricingItemRequest $request,
        PricingItem $pricingItem
    ): RedirectResponse {
        DB::transaction(function () use ($request, $pricingItem) {

            $data = $request->validated();

            $specifications = $data['specifications'] ?? null;

            unset($data['specifications']);

            $pricingItem->update($data);

            if ($specifications !== null) {

                $pricingItem->specifications()->delete();

                foreach ($specifications as $specification) {

                    if (blank($specification)) {
                        continue;
                    }

                    $pricingItem->specifications()->create([
                        'name' => $specification,
                    ]);
                }
            }
        });

        return redirect()
            ->route('pricing-items.index')
            ->with(
                'success',
                'تم تعديل بند التسعير بنجاح.'
            );
    }
    
    public function destroy(
        PricingItem $pricingItem
    ): RedirectResponse {
        if ($pricingItem->projects()->exists()) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'لا يمكن حذف بند التسعير لأنه مرتبط بمشروع أو أكثر.'
                );
        }

        $pricingItem->delete();

        return redirect()
            ->route('pricing-items.index')
            ->with(
                'success',
                'تم حذف بند التسعير بنجاح.'
            );
    }
}