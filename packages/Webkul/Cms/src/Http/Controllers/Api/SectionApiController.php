<?php

namespace Webkul\Cms\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithSectionPayload;
use Webkul\Cms\Http\Requests\SectionRequest;
use Webkul\Cms\Repositories\SectionRepository;

class SectionApiController extends Controller
{
    use InteractsWithSectionPayload;

    public function __construct(protected SectionRepository $sectionRepository) {}

    public function index(Request $request): JsonResponse
    {

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);

        $query = $this->sectionRepository->getModel()
            ->newQuery()
            ->with('translations')
            ->orderByDesc('id');

        return response()->json($query->paginate($perPage));
    }

    public function show(int $id): JsonResponse
    {

        $section = $this->sectionRepository->findOrFail($id);
        $section->loadMissing('translations');

        return response()->json($section);
    }

    public function store(SectionRequest $request): JsonResponse
    {

        Event::dispatch('cms.sections.create.before');

        $data = $this->sanitizePayload($request->validated(), true);

        $section = $this->sectionRepository->create($data);

        Event::dispatch('cms.sections.create.after', $section);

        $section->loadMissing('translations');

        return response()->json($section, 201);
    }

    public function update(SectionRequest $request, int $id): JsonResponse
    {

        Event::dispatch('cms.sections.update.before', $id);

        $data = $this->sanitizePayload($request->validated());

        $section = $this->sectionRepository->update($data, $id);

        Event::dispatch('cms.sections.update.after', $section);

        $section->loadMissing('translations');

        return response()->json($section);
    }

    public function destroy(int $id): JsonResponse
    {

        $section = $this->sectionRepository->findOrFail($id);

        Event::dispatch('cms.sections.delete.before', $id);

        $section?->delete();

        Event::dispatch('cms.sections.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.sections.messages.delete-success'),
        ]);
    }
}
