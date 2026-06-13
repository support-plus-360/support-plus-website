@php
    $entity = $entity ?? null;
    $uid = $uid ?? 'cms-icon-media-' . uniqid();
    $iconMedia = $entity?->getFirstMedia('icon_media');
    $iconMediaAlt = old('icon_media_alt', $iconMedia?->getCustomProperty('media_alt'));
    $oldDeleteIcon = old('delete_icon_media');
@endphp

<div class="box-shadow rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
    <div class="mb-4">
        <p class="text-base font-semibold text-gray-800 dark:text-white">
            @lang('cms::app.services.form.icon')
        </p>
        <p class="text-xs text-gray-500 dark:text-gray-400">
            @lang('cms::app.services.form.icon-help')
        </p>
    </div>

    <input type="hidden" name="delete_icon_media" value="{{ $oldDeleteIcon ? 1 : 0 }}" data-icon-delete-flag="{{ $uid }}">

    <div class="relative mb-3 overflow-hidden rounded-md border border-gray-200 dark:border-gray-700 {{ $iconMedia && ! $oldDeleteIcon ? '' : 'hidden' }}" data-icon-media-preview="{{ $uid }}">
        @if($iconMedia && ! $oldDeleteIcon)
            <button
                type="button"
                class="absolute right-2 top-2 z-10 inline-flex h-7 w-7 items-center justify-center rounded-full border border-red-300 bg-white text-lg leading-none text-red-600 hover:bg-red-50 dark:border-red-800 dark:bg-gray-900 dark:text-red-400"
                data-icon-media-remove="{{ $uid }}"
                aria-label="Delete icon"
            >&times;</button>
            <img src="{{ $iconMedia->getUrl() }}" alt="Icon preview" class="object-contain" style="height: 120px; width: 120px;">
        @endif
    </div>

    <div class="flex flex-col gap-3">
        <input
            type="file"
            name="icon_media"
            accept="image/*"
            data-icon-media-input="{{ $uid }}"
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200"
        />
        <x-admin::form.control-group.error control-name="icon_media" />

        <x-admin::form.control-group class="!mb-0">
            <x-admin::form.control-group.label>
                @lang('cms::app.services.form.icon-alt')
            </x-admin::form.control-group.label>
            <x-admin::form.control-group.control
                type="text"
                name="icon_media_alt"
                id="{{ $uid }}_icon_media_alt"
                :value="$iconMediaAlt"
                :label="trans('cms::app.services.form.icon-alt')"
            />
            <x-admin::form.control-group.error control-name="icon_media_alt" />
        </x-admin::form.control-group>
    </div>
</div>

@pushOnce('scripts', 'cms.icon-media-manager')
<script>
(() => {
    const initIconMedia = (uid) => {
        const input = document.querySelector(`[data-icon-media-input="${uid}"]`);
        const preview = document.querySelector(`[data-icon-media-preview="${uid}"]`);
        const deleteFlag = document.querySelector(`[data-icon-delete-flag="${uid}"]`);
        const removeBtn = document.querySelector(`[data-icon-media-remove="${uid}"]`);

        if (!input || !preview || !deleteFlag) {
            return;
        }

        removeBtn?.addEventListener('click', () => {
            deleteFlag.value = '1';
            preview.classList.add('hidden');
            preview.innerHTML = '';
            input.value = '';
        });

        input.addEventListener('change', () => {
            const file = input.files?.[0];

            if (!file) {
                return;
            }

            deleteFlag.value = '0';

            const reader = new FileReader();
            reader.onload = (e) => {
                preview.classList.remove('hidden');
                preview.innerHTML = `
                    <button type="button"
                        class="absolute right-2 top-2 z-10 inline-flex h-7 w-7 items-center justify-center rounded-full border border-red-300 bg-white text-lg leading-none text-red-600 hover:bg-red-50 dark:border-red-800 dark:bg-gray-900 dark:text-red-400"
                        data-icon-media-remove="${uid}"
                        aria-label="Delete icon">&times;</button>
                    <img src="${e.target.result}" alt="Icon preview" class="object-contain" style="height: 120px; width: 120px;">
                `;
                preview.querySelector(`[data-icon-media-remove="${uid}"]`)?.addEventListener('click', () => {
                    deleteFlag.value = '1';
                    preview.classList.add('hidden');
                    preview.innerHTML = '';
                    input.value = '';
                });
            };
            reader.readAsDataURL(file);
        });
    };

    document.querySelectorAll('[data-icon-media-input]').forEach((input) => {
        const uid = input.getAttribute('data-icon-media-input');
        if (uid) {
            initIconMedia(uid);
        }
    });
})();
</script>
@endPushOnce
