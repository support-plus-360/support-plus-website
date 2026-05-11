<?php

namespace Webkul\Cms\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait InteractsWithCmsMedia
{
    protected function syncMediaFromRequest(Request $request, HasMedia $model): void
    {
        $this->syncMainMedia($request, $model);
        $this->syncGalleryMedia($request, $model);
    }

    protected function syncMainMedia(Request $request, HasMedia $model): void
    {
        if ($request->boolean('delete_main_media')) {
            $model->clearMediaCollection('main_media');
        }

        if ($request->hasFile('main_media')) {
            $model->clearMediaCollection('main_media');
            $model->addMediaFromRequest('main_media')->toMediaCollection('main_media');
        }

        $mainMedia = $model->getFirstMedia('main_media');

        if (! $mainMedia) {
            return;
        }

        $mainMedia->setCustomProperty('media_alt', $request->input('main_media_alt'));
        $mainMedia->save();
    }

    /**
     * Sync main_media using nested request keys, e.g. sections.0.main_media (page builder).
     *
     * @param  string  $dotPrefix  Dot notation without trailing dot (e.g. "sections.0" or "sections.0.items.1").
     */
    protected function syncMainMediaFromPrefix(Request $request, HasMedia $model, string $dotPrefix): void
    {
        $deletePath = $dotPrefix.'.delete_main_media';
        if ($request->boolean($deletePath)) {
            $model->clearMediaCollection('main_media');
        }

        $filePath = $dotPrefix.'.main_media';
        if ($request->hasFile($filePath)) {
            $model->clearMediaCollection('main_media');
            $model->addMediaFromRequest($filePath)->toMediaCollection('main_media');
        }

        $mainMedia = $model->getFirstMedia('main_media');
        if (! $mainMedia) {
            return;
        }

        $altPath = $dotPrefix.'.main_media_alt';
        $mainMedia->setCustomProperty('media_alt', $request->input($altPath));
        $mainMedia->save();
    }

    protected function syncGalleryMedia(Request $request, HasMedia $model): void
    {
        /** @var Collection<int, Media> $existingGallery */
        $existingGallery = $model->getMedia('gallery')->keyBy('id');

        foreach ((array) $request->input('gallery_existing', []) as $payload) {
            $mediaId = (int) ($payload['id'] ?? 0);

            if (! $mediaId || ! $existingGallery->has($mediaId)) {
                continue;
            }

            /** @var Media $media */
            $media = $existingGallery->get($mediaId);

            if (! empty($payload['delete'])) {
                $media->delete();
                continue;
            }

            $media->setCustomProperty('media_alt', $payload['media_alt'] ?? null);
            $media->order_column = isset($payload['order']) && $payload['order'] !== ''
                ? (int) $payload['order']
                : null;
            $media->save();
        }

        foreach ((array) $request->input('gallery_new', []) as $payload) {
            $file = $payload['file'] ?? null;

            if (! $file) {
                continue;
            }

            $media = $model->addMedia($file)->toMediaCollection('gallery');
            $media->setCustomProperty('media_alt', $payload['media_alt'] ?? null);
            $media->order_column = isset($payload['order']) && $payload['order'] !== ''
                ? (int) $payload['order']
                : null;
            $media->save();
        }

        foreach ((array) $request->file('gallery_files', []) as $index => $file) {
            if (! $file) {
                continue;
            }

            $meta = (array) $request->input("gallery_files_meta.{$index}", []);

            $media = $model->addMedia($file)->toMediaCollection('gallery');
            $media->setCustomProperty('media_alt', $meta['media_alt'] ?? null);
            $media->order_column = isset($meta['order']) && $meta['order'] !== ''
                ? (int) $meta['order']
                : $index + 1;
            $media->save();
        }
    }
}
