<?php

namespace Webkul\Cms\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithPagePayload;
use Webkul\Cms\Http\Requests\PageBuilderRequest;
use Webkul\Cms\Repositories\PageRepository;
use Webkul\Cms\Services\PageBuilderService;
use Webkul\Cms\Support\SectionLayoutPreview;
use Webkul\Company\Models\Company;

class PageBuilderController extends Controller
{
    use InteractsWithPagePayload;

    public function __construct(
        protected PageRepository $pageRepository,
        protected PageBuilderService $pageBuilderService,
    ) {}

    public function edit(int $id): View
    {
        $page = $this->pageRepository->findOrFail($id);

        $page->load([
            'translations',
            'sections' => fn ($q) => $q->orderBy('order')->with([
                'media',
                'translations',
                'items' => fn ($iq) => $iq->orderBy('order')->with([
                    'media',
                    'translations',
                    'links' => fn ($lq) => $lq->orderBy('order')->with('translations'),
                ]),
                'links' => fn ($lq) => $lq->orderBy('order')->with('translations'),
            ]),
            'links' => fn ($lq) => $lq->orderBy('order')->with('translations'),
        ]);

        $locales = $this->supportedLocales();
        $companies = Company::query()->select('id', 'name')->get();

        $sectionLayouts = config('cms.section_layouts.layouts', []);
        $defaultSectionLayout = config('cms.section_layouts.default', array_key_first($sectionLayouts) ?: 'home_hero');

        $cmsBuilderLayoutPreview = SectionLayoutPreview::scriptPayload($sectionLayouts);

        return view('cms::pages.builder', compact(
            'page',
            'locales',
            'companies',
            'sectionLayouts',
            'defaultSectionLayout',
            'cmsBuilderLayoutPreview'
        ));
    }

    /**
     * Serve a layout reference image from public (publish) or package assets.
     */
    public function layoutPreviewAsset(string $path): BinaryFileResponse
    {
        $relative = SectionLayoutPreview::normalizeRelativePreviewPath($path);

        if ($relative === null) {
            abort(404);
        }

        $publicPath = SectionLayoutPreview::publicPreviewDirectory().'/'.$relative;
        if (File::isFile($publicPath)) {
            return response()->file($publicPath);
        }

        $packagePath = SectionLayoutPreview::packagePreviewDirectory().'/'.$relative;
        if (File::isFile($packagePath)) {
            return response()->file($packagePath);
        }

        abort(404);
    }

    public function update(PageBuilderRequest $request, int $id): RedirectResponse
    {
        Event::dispatch('cms.pages.update.before', $id);

        $validated = $request->validated();

        $pagePayload = Arr::except($validated, [
            'sync_sections',
            'sync_page_links',
            'prune_sections',
            'prune_page_links',
            'sections',
            'page_links',
        ]);

        $page = $this->pageRepository->update($this->sanitizePayload($pagePayload), $id);

        $structure = [];
        if ($request->boolean('sync_page_links')) {
            $structure['page_links'] = $validated['page_links'] ?? [];
            $structure['prune_page_links'] = $request->boolean('prune_page_links');
        }
        if ($request->boolean('sync_sections')) {
            $structure['sections'] = $validated['sections'] ?? [];
            $structure['prune_sections'] = $request->boolean('prune_sections');
        }

        if ($structure !== []) {
            $this->pageBuilderService->syncStructure($page->fresh(), $structure, $request);
        }

        Event::dispatch('cms.pages.update.after', $page->fresh());

        session()->flash('success', trans('cms::app.pages.builder.messages.update-success'));

        return redirect()->route('admin.cms.pages.builder', $page->id);
    }
}
