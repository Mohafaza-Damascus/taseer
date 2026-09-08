<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Http\Requests\IncomingEntity\CreateIncomingEntityRequest;
use App\Http\Requests\IncomingEntity\UpdateIncomingEntityRequest;
use App\Models\IncomingEntity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IncomingEntityController extends Controller
{
    /**
     * Display a listing of incoming entities.
     */
    public function index(Request $request): View
    {
        $incomingEntities = IncomingEntity::query()
            ->latest()
            ->paginate(15);

        return view(
            'incoming_entities.index',
            compact('incomingEntities')
        );
    }

    /**
     * Show the form for creating a new incoming entity.
     */
    public function create(): View
    {
        return view('incoming_entities.create');
    }

    /**
     * Store a newly created incoming entity.
     */
    public function store(
        CreateIncomingEntityRequest $request
    ): RedirectResponse {
        IncomingEntity::create(
            $request->validated()
        );

        return redirect()
            ->route('incoming-entities.index')
            ->with(
                'success',
                'تم إنشاء الجهة الواردة بنجاح.'
            );
    }

    /**
     * Display the specified incoming entity.
     */
    public function show(
        IncomingEntity $incomingEntity
    ): View {
        $incomingEntity->load('projects');

        return view(
            'incoming_entities.show',
            compact('incomingEntity')
        );
    }

    /**
     * Show the form for editing the specified incoming entity.
     */
    public function edit(
        IncomingEntity $incomingEntity
    ): View {
        return view(
            'incoming_entities.edit',
            compact('incomingEntity')
        );
    }

    /**
     * Update the specified incoming entity.
     */
    public function update(
        UpdateIncomingEntityRequest $request,
        IncomingEntity $incomingEntity
    ): RedirectResponse {
        $incomingEntity->update(
            $request->validated()
        );

        return redirect()
            ->route('incoming-entities.index')
            ->with(
                'success',
                'تم تعديل الجهة الواردة بنجاح.'
            );
    }

    /**
     * Remove the specified incoming entity.
     */
    public function destroy(
        IncomingEntity $incomingEntity
    ): RedirectResponse {
        if ($incomingEntity->projects()->exists()) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'لا يمكن حذف الجهة الواردة لأنها مرتبطة بمشروع أو أكثر.'
                );
        }

        $incomingEntity->delete();

        return redirect()
            ->route('incoming-entities.index')
            ->with(
                'success',
                'تم حذف الجهة الواردة بنجاح.'
            );
    }
}