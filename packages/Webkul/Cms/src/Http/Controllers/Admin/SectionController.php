<?php

namespace Webkul\Cms\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\DataGrids\SectionDataGrid;
use Webkul\Cms\Http\Requests\SectionRequest;
use Webkul\Cms\Repositories\SectionRepository;
use Webkul\Cms\Models\Page;
use Webkul\Company\Models\Company;
class SectionController extends Controller
{
    public function __construct(protected SectionRepository $sectionRepository) {}

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(SectionDataGrid::class)->process();
        }

        return view('cms::sections.index');
    }

    public function create(): View
    {
        $locales = $this->supportedLocales();

        $pages = Page::orderBy('name')->get();

        $companies = Company::select('id', 'name')->get();

        return view('cms::sections.create', compact('locales', 'pages', 'companies'));
    }

    public function store(SectionRequest $request): RedirectResponse
    {
        Event::dispatch('cms.sections.create.before');

        $data = $this->sanitizePayload($request->validated(), true);

        $section = $this->sectionRepository->create($data);

        Event::dispatch('cms.sections.create.after', $section);

        session()->flash('success', trans('cms::app.sections.messages.create-success'));

        return redirect()->route('admin.cms.sections.index');
    }

    public function edit(int $id): View
    {
        $section = $this->sectionRepository->findOrFail($id);

        $section->loadMissing('translations');

        $locales = $this->supportedLocales();

	$pages = Page::orderBy('name')->get();

	$companies = Company::select('id', 'name')->get();

        return view('cms::sections.edit', compact('section', 'locales', 'pages', 'companies'));
    }

    public function update(SectionRequest $request, int $id): RedirectResponse
    {
        Event::dispatch('cms.sections.update.before', $id);

        $data = $this->sanitizePayload($request->validated());

        $section = $this->sectionRepository->update($data, $id);

        Event::dispatch('cms.sections.update.after', $section);

        session()->flash('success', trans('cms::app.sections.messages.update-success'));

        return redirect()->route('admin.cms.sections.index');
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


public function restore(int $id): JsonResponse
{
    $section = $this->sectionRepository->getModel()->withTrashed()->findOrFail($id);

    Event::dispatch('cms.sections.restore.before', $id);

    $section?->restore();

    Event::dispatch('cms.sections.restore.after', $id);

    return response()->json([
        'message' => trans('cms::app.sections.messages.restore-success'),
    ]);
}

// force delete company
public function forceDelete(int $id): JsonResponse
{
    $section = $this->sectionRepository->getModel()->withTrashed()->findOrFail($id);

    Event::dispatch('cms.sections.forceDelete.before', $id);

    $section?->forceDelete();


    Event::dispatch('cms.sections.forceDelete.after', $id);

    return response()->json([
        'message' => trans('cms::app.sections.messages.forceDelete-success'),
    ]);


}  


    private function supportedLocales(): array
    {
        /**
         * Note: sections table currently stores locale as 2 chars.
         * Keeping it limited to 'en' and 'ar' to match migration.
         */
        return ['en' => 'English', 'ar' => 'Arabic'];
    }

    private function sanitizePayload(array $data, bool $forceAuthor = false): array
    {
        $data['is_active'] = (bool) ($data['is_active'] ?? false);
        $data['order'] = (int) ($data['order'] ?? 0);

        if ($forceAuthor && empty($data['author_id']) && auth()->check()) {
            $data['author_id'] = auth()->id();
        }

        $translations = [];

        $allowedLocales = array_keys($this->supportedLocales());

        foreach (($data['translations'] ?? []) as $locale => $payload) {
            if (! in_array($locale, $allowedLocales, true)) {
                continue;
            }

            if (! is_array($payload)) {
                continue;
            }

            $translations[$locale] = [
                'title'       => $payload['title'] ?? '',
                'subtitle'    => $payload['subtitle'] ?? null,
                'description' => $payload['description'] ?? null,
                'locale'      => $locale,
            ];
        }

        unset($data['translations']);

        return $data + $translations;
    }
}

