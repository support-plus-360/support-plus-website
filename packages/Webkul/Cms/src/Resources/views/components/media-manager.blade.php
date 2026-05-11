@php
    $entity = $entity ?? null;
    $uid = $uid ?? 'cms-media-' . uniqid();
    $mainOnly = $mainOnly ?? false;
    $namePrefix = $namePrefix ?? '';
    $field = fn (string $name) => $namePrefix !== '' ? $namePrefix.'['.$name.']' : $name;
    $dotOldPrefix = $namePrefix !== '' ? preg_replace('/\[([^\]]*)\]/', '.$1', $namePrefix) : '';
    $oldField = fn (string $leaf) => $dotOldPrefix !== '' ? $dotOldPrefix.'.'.$leaf : $leaf;
    $mainMedia = $entity?->getFirstMedia('main_media');
    $galleryMedia = $mainOnly ? collect() : ($entity ? $entity->getMedia('gallery')->sortBy('order_column') : collect());
    $nextGalleryOrder = max(1, ((int) $galleryMedia->max('order_column')) + 1);
    $mainMediaAlt = old($oldField('main_media_alt'), $mainMedia?->getCustomProperty('media_alt'));
    $oldDeleteMain = old($oldField('delete_main_media'));
@endphp

<div class="box-shadow rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
    <div class="mb-4 flex items-center justify-between gap-2">
        <div>
            <p class="text-base font-semibold text-gray-800 dark:text-white">Media</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">
                {{ $mainOnly ? 'Main image or video (optional).' : 'Manage main media and gallery assets.' }}
            </p>
        </div>
    </div>

    <div class="{{ $mainOnly ? 'grid grid-cols-1 gap-4' : 'grid grid-cols-1 gap-4 lg:grid-cols-2' }}">
        <div class="rounded-md border border-gray-200 p-4 dark:border-gray-800">
            <p class="mb-3 text-sm font-semibold text-gray-800 dark:text-white">Main Media (optional)</p>

            <input type="hidden" name="{{ $field('delete_main_media') }}" value="{{ $oldDeleteMain ? 1 : 0 }}" data-main-delete-flag="{{ $uid }}">
            <div class="relative mb-3 overflow-hidden rounded-md border border-gray-200 dark:border-gray-700 {{ $mainMedia && ! $oldDeleteMain ? '' : 'hidden' }}" data-main-media-preview="{{ $uid }}">
                @if($mainMedia && ! $oldDeleteMain)
                    <button
                        type="button"
                        class="absolute right-2 top-2 z-10 inline-flex h-7 w-7 items-center justify-center rounded-full border border-red-300 bg-white text-lg leading-none text-red-600 hover:bg-red-50 dark:border-red-800 dark:bg-gray-900 dark:text-red-400"
                        data-main-media-remove="{{ $uid }}"
                        aria-label="Delete main media"
                    >&times;</button>
                    @if(str_starts_with((string) $mainMedia->mime_type, 'video/'))
                        <video controls class="bg-black object-contain" style="height: 200px; width: 200px; object-fit: cover;">
                            <source src="{{ $mainMedia->getUrl() }}" type="{{ $mainMedia->mime_type }}">
                        </video>
                    @else
                        <img src="{{ $mainMedia->getUrl() }}" alt="Main media preview" style="height: 200px; width: 200px; object-fit: cover;">
                    @endif
                @endif
            </div>

            <div class="flex flex-col gap-3">
                <input type="file" name="{{ $field('main_media') }}" accept="image/*,video/*" data-main-media-input="{{ $uid }}" class="cms-section-preview-trigger w-full rounded-md border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200">
                <x-admin::form.control-group.error :control-name="$oldField('main_media')" />

                <x-admin::form.control-group class="!mb-0">
                    <x-admin::form.control-group.label>Main Media Alt (optional)</x-admin::form.control-group.label>
                    <x-admin::form.control-group.control
                        type="text"
                        name="{{ $field('main_media_alt') }}"
                        id="{{ $uid }}_main_media_alt"
                        :value="$mainMediaAlt"
                        label="Main Media Alt"
                    />
                    <x-admin::form.control-group.error :control-name="$oldField('main_media_alt')" />
                </x-admin::form.control-group>

            </div>
        </div>

        @if (! $mainOnly)
        <div class="rounded-md border border-gray-200 p-4 dark:border-gray-800">
            <div class="mb-3 flex items-center justify-between">
                <p class="text-sm font-semibold text-gray-800 dark:text-white">Gallery (optional)</p>
                <span class="text-xs text-gray-500 dark:text-gray-400">Upload multiple files at once.</span>
            </div>

            <input
                type="file"
                name="gallery_files[]"
                accept="image/*,video/*"
                multiple
                data-gallery-multi-input="{{ $uid }}"
                class="mb-3 w-full rounded-md border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200"
            >
            <x-admin::form.control-group.error control-name="gallery_files" />
            <x-admin::form.control-group.error control-name="gallery_files.*" />

            <div
                class="mb-3 hidden grid grid-cols-1 gap-3"
                data-gallery-multi-preview="{{ $uid }}"
                data-order-start="{{ $nextGalleryOrder }}"
            ></div>

            <div class="space-y-3" data-gallery-container="{{ $uid }}">
                @foreach($galleryMedia as $media)
                    <div class="relative rounded-md border border-gray-200 p-3 dark:border-gray-700" data-gallery-row>
                        <input type="hidden" name="gallery_existing[{{ $media->id }}][id]" value="{{ $media->id }}">
                        <input type="hidden" name="gallery_existing[{{ $media->id }}][delete]" value="0" data-delete-flag>
                        <button
                            type="button"
                            class="absolute right-2 top-2 inline-flex h-7 w-7 items-center justify-center rounded-full border border-red-300 bg-white text-lg leading-none text-red-600 hover:bg-red-50 dark:border-red-800 dark:bg-gray-900 dark:text-red-400"
                            data-gallery-remove-existing
                            aria-label="Delete this media"
                        >&times;</button>

                        <div class="mb-3 overflow-hidden rounded border border-gray-200 dark:border-gray-700">
                            @if(str_starts_with((string) $media->mime_type, 'video/'))
                                <video controls class="w-full bg-black object-contain" style="height: 200px; width: 200px; object-fit: cover;">
                                    <source src="{{ $media->getUrl() }}" type="{{ $media->mime_type }}">
                                </video>
                            @else
                                <img src="{{ $media->getUrl() }}" alt="Gallery media preview" style="height: 200px; width: 200px; object-fit: cover;">
                            @endif
                        </div>

                        <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                            <input
                                type="text"
                                name="gallery_existing[{{ $media->id }}][media_alt]"
                                value="{{ old('gallery_existing.'.$media->id.'.media_alt', $media->getCustomProperty('media_alt')) }}"
                                placeholder="Media alt (optional)"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200"
                            >
                            <input
                                type="number"
                                name="gallery_existing[{{ $media->id }}][order]"
                                value="{{ old('gallery_existing.'.$media->id.'.order', $media->order_column ?: $loop->iteration) }}"
                                placeholder="Order"
                                min="1"
                                required
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200"
                            >
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

</div>

@pushOnce('scripts')
    <script>
        (() => {
            const galleryFilesByUid = new Map();

            const renderPreview = (container, file, style = 'style="height: 200px; width: 200px; object-fit: cover;"', removeButtonHtml = '') => {
                if (!container) {
                    return;
                }

                if (!file) {
                    container.innerHTML = '';
                    container.classList.add('hidden');
                    return;
                }

                const objectUrl = URL.createObjectURL(file);
                const isVideo = file.type.startsWith('video/');

                container.classList.remove('hidden');
                container.innerHTML = isVideo
                    ? `${removeButtonHtml}<video controls class="w-full bg-black object-contain" style="${style}"><source src="${objectUrl}" type="${file.type}"></video>`
                    : `${removeButtonHtml}<img src="${objectUrl}" alt="Media preview" style="${style} w-full object-cover">`;
            };

            document.addEventListener('click', (event) => {
                const target = event.target instanceof Element ? event.target : null;
                const removeBtn = target?.closest('[data-gallery-remove]');
                const removeExistingBtn = target?.closest('[data-gallery-remove-existing]');
                const removeNewBtn = target?.closest('[data-gallery-remove-new]');
                const removeMainBtn = target?.closest('[data-main-media-remove]');

                if (removeMainBtn) {
                    const uid = removeMainBtn.getAttribute('data-main-media-remove');
                    const preview = document.querySelector(`[data-main-media-preview="${uid}"]`);
                    const mainInput = document.querySelector(`[data-main-media-input="${uid}"]`);
                    const deleteFlag = document.querySelector(`[data-main-delete-flag="${uid}"]`);

                    if (mainInput) {
                        mainInput.value = '';
                    }

                    if (deleteFlag) {
                        deleteFlag.value = '1';
                    }

                    preview?.classList.add('hidden');
                    preview.innerHTML = '';
                    return;
                }

                if (removeExistingBtn) {
                    const row = removeExistingBtn.closest('[data-gallery-row]');
                    const deleteFlag = row?.querySelector('[data-delete-flag]');

                    if (deleteFlag) {
                        deleteFlag.value = '1';
                    }

                    row?.classList.add('hidden');
                    return;
                }

                if (removeNewBtn) {
                    const uid = removeNewBtn.getAttribute('data-gallery-remove-new');
                    const index = Number(removeNewBtn.getAttribute('data-gallery-new-index'));
                    const input = document.querySelector(`[data-gallery-multi-input="${uid}"]`);
                    const current = galleryFilesByUid.get(uid) ?? [];
                    const next = current.filter((_, i) => i !== index);
                    galleryFilesByUid.set(uid, next);

                    if (input) {
                        const dataTransfer = new DataTransfer();
                        next.forEach((file) => dataTransfer.items.add(file));
                        input.files = dataTransfer.files;
                    }

                    const changeEvent = new Event('change', { bubbles: true });
                    input?.dispatchEvent(changeEvent);
                    return;
                }

                if (removeBtn) {
                    removeBtn.closest('[data-gallery-row]')?.remove();
                }
            }, true);

            document.addEventListener('change', (event) => {
                const target = event.target instanceof Element ? event.target : null;

                if (!target) {
                    return;
                }

                const mainInput = target.closest('[data-main-media-input]');

                if (mainInput) {
                    const uid = mainInput.getAttribute('data-main-media-input');
                    const preview = document.querySelector(`[data-main-media-preview="${uid}"]`);
                    const deleteFlag = document.querySelector(`[data-main-delete-flag="${uid}"]`);
                    if (deleteFlag) {
                        deleteFlag.value = '0';
                    }

                    renderPreview(
                        preview,
                        mainInput.files?.[0],
                        'height: 200px; width: 200px; object-fit: cover;"',
                        `<button type="button" class="absolute right-2 top-2 z-10 inline-flex h-7 w-7 items-center justify-center rounded-full border border-red-300 bg-white text-lg leading-none text-red-600 hover:bg-red-50 dark:border-red-800 dark:bg-gray-900 dark:text-red-400" data-main-media-remove="${uid}" aria-label="Delete main media">&times;</button>`
                    );
                    return;
                }

                const galleryMultiInput = target.closest('[data-gallery-multi-input]');

                if (galleryMultiInput) {
                    const uid = galleryMultiInput.getAttribute('data-gallery-multi-input');
                    const previewContainer = document.querySelector(`[data-gallery-multi-preview="${uid}"]`);
                    const files = Array.from(galleryMultiInput.files ?? []);
                    galleryFilesByUid.set(uid, files);

                    if (!previewContainer) {
                        return;
                    }

                    previewContainer.innerHTML = '';
                    previewContainer.classList.toggle('hidden', files.length === 0);

                    const orderStart = Number(previewContainer.dataset.orderStart || '1');

                    files.forEach((file, index) => {
                        const tile = document.createElement('div');
                        tile.className = 'relative rounded border border-gray-200 p-3 dark:border-gray-700';

                        const objectUrl = URL.createObjectURL(file);

                        const previewHtml = file.type.startsWith('video/')
                            ? `<video controls class="bg-black object-contain" style="height: 200px; width: 200px; object-fit: cover;"><source src="${objectUrl}" type="${file.type}"></video>`
                            : `<img src="${objectUrl}" alt="Gallery upload preview" style="height: 200px; width: 200px; object-fit: cover;">`;

                        tile.innerHTML = `
                            <button type="button" class="absolute right-2 top-2 inline-flex h-7 w-7 items-center justify-center rounded-full border border-red-300 bg-white text-lg leading-none text-red-600 hover:bg-red-50 dark:border-red-800 dark:bg-gray-900 dark:text-red-400" data-gallery-remove-new="${uid}" data-gallery-new-index="${index}" aria-label="Remove selected media">&times;</button>
                            ${previewHtml}
                            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                                <input type="text" name="gallery_files_meta[${index}][media_alt]" placeholder="Media alt (optional)" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200">
                                <input type="number" name="gallery_files_meta[${index}][order]" min="1" required value="${orderStart + index}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200">
                            </div>
                        `;

                        previewContainer.appendChild(tile);
                    });
                }
            });

        })();
    </script>
@endPushOnce
