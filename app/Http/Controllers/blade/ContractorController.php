<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contractor\CreateContractorRequest;
use App\Http\Requests\Contractor\UpdateContractorRequest;
use App\Models\Contractor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContractorController extends Controller
{
    /**
     * Display contractors.
     */
    public function index(Request $request): View
    {
        $contractors = Contractor::query()
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view(
            'contractors.index',
            compact('contractors')
        );
    }

    /**
     * Show create contractor page.
     */
    public function create(): View
    {
        return view('contractors.create');
    }

    /**
     * Store contractor.
     */
    public function store(
        CreateContractorRequest $request
    ): RedirectResponse {
        $data = $request->validated();

        Contractor::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'national_number' =>
                $data['national_number'],
            'company_name' =>
                $data['company_name'] ?? null,
        ]);

        return redirect()
            ->route('contractors.index')
            ->with('success', 'تم إنشاء المتعهد بنجاح.');
    }

    /**
     * Display contractor.
     */
    public function show(
        Contractor $contractor
    ): View {
        $contractor->load('projects');

        return view(
            'contractors.show',
            compact('contractor')
        );
    }

    /**
     * Show edit page.
     */
    public function edit(
        Contractor $contractor
    ): View {
        return view(
            'contractors.edit',
            compact('contractor')
        );
    }

    /**
     * Update contractor.
     */
    public function update(
        UpdateContractorRequest $request,
        Contractor $contractor
    ): RedirectResponse {
        $data = $request->validated();

        $updateData = [];

        if (array_key_exists('name', $data)) {
            $updateData['name'] = $data['name'];
        }

        if (array_key_exists('phone', $data)) {
            $updateData['phone'] = $data['phone'];
        }

        if (array_key_exists('national_number', $data)) {
            $updateData['national_number'] =
                $data['national_number'];
        }

        if (array_key_exists('company_name', $data)) {
            $updateData['company_name'] =
                $data['company_name'];
        }

        if (!empty($updateData)) {
            $contractor->update($updateData);
        }

        return redirect()
            ->route('contractors.index')
            ->with('success', 'تم تعديل المتعهد بنجاح.');
    }

    /**
     * Delete contractor.
     */
    public function destroy(
        Contractor $contractor
    ): RedirectResponse {
        if ($contractor->projects()->exists()) {
            return back()->withErrors([
                'error' =>
                    'لا يمكن حذف المتعهد لأنه مرتبط بمشروع أو أكثر.',
            ]);
        }

        $contractor->delete();

        return redirect()
            ->route('contractors.index')
            ->with('success', 'تم حذف المتعهد بنجاح.');
    }
}