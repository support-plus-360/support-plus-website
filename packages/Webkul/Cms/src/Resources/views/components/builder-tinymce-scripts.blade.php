@pushOnce('scripts', 'cms.builder-tinymce')
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.6.2/tinymce.min.js"
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
></script>
<script>
(function () {
    const uploadUrl = @json(route('admin.tinymce.upload'));
    const csrfToken = @json(csrf_token());
    const documentBaseUrl = @json(asset('/'));

    const skin = () => document.documentElement.classList.contains('dark') ? 'oxide-dark' : 'oxide';
    const contentCss = () => document.documentElement.classList.contains('dark') ? 'dark' : 'default';

    const panelIsVisible = (textarea) => {
        const panel = textarea.closest('.cms-locale-panel');

        if (! panel) {
            return true;
        }

        if (panel.classList.contains('hidden') || panel.hidden) {
            return false;
        }

        try {
            return window.getComputedStyle(panel).display !== 'none';
        } catch (e) {
            return true;
        }
    };

    const notifyEditorChange = (textarea) => {
        const section = textarea?.closest?.('[data-cms-section]');

        if (section && typeof window.__cmsBuilderDebouncePreview === 'function') {
            window.__cmsBuilderDebouncePreview(section);
        }
    };

    const uploadImage = (blobInfo, progress) => new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', uploadUrl);
        xhr.upload.onprogress = (e) => progress((e.loaded / e.total) * 100);
        xhr.onload = () => {
            if (xhr.status < 200 || xhr.status >= 300) {
                reject('Upload failed');
                return;
            }
            const json = JSON.parse(xhr.responseText);
            if (! json?.location) {
                reject('Invalid upload response');
                return;
            }
            resolve(json.location);
        };
        xhr.onerror = () => reject('Upload failed');
        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        xhr.send(formData);
    });

    const baseEditorConfig = () => ({
        relative_urls: false,
        remove_script_host: false,
        document_base_url: documentBaseUrl,
        plugins: 'lists link image table code preview fullscreen searchreplace wordcount media autolink',
        toolbar: 'undo redo | blocks | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table blockquote hr | removeformat | searchreplace preview fullscreen code',
        min_height: 280,
        menubar: false,
        statusbar: true,
        promotion: false,
        branding: false,
        skin: skin(),
        content_css: contentCss(),
        images_upload_handler: uploadImage,
        setup: (editor) => {
            const sync = () => notifyEditorChange(editor.getElement());
            editor.on('input change keyup undo redo SetContent', sync);
        },
    });

    window.cmsBuilderInitRichEditors = (root = document) => {
        if (typeof tinymce === 'undefined') {
            return false;
        }

        const pending = Array.from(root.querySelectorAll('textarea.cms-builder-rich-editor'))
            .filter((el) => el.id && ! tinymce.get(el.id) && panelIsVisible(el));

        if (! pending.length) {
            return true;
        }

        const config = baseEditorConfig();

        pending.forEach((target) => {
            tinymce.init({ ...config, target });
        });

        return true;
    };

    window.cmsBuilderResizeRichEditors = (root = document) => {
        if (typeof tinymce === 'undefined') {
            return;
        }

        root.querySelectorAll('textarea.cms-builder-rich-editor').forEach((textarea) => {
            const editor = tinymce.get(textarea.id);

            if (editor) {
                editor.fire('ResizeEditor');
            }
        });
    };

    const bootEditors = (attempt = 0) => {
        if (typeof tinymce === 'undefined') {
            if (attempt < 80) {
                window.setTimeout(() => bootEditors(attempt + 1), 150);
            }

            return;
        }

        const root = document.getElementById('cms-sections-root') || document;

        if (! root.querySelector('textarea.cms-builder-rich-editor')) {
            if (attempt < 80) {
                window.setTimeout(() => bootEditors(attempt + 1), 150);
            }

            return;
        }

        window.cmsBuilderInitRichEditors(root);
    };

    window.addEventListener('load', () => {
        window.setTimeout(() => bootEditors(0), 150);
    });

    document.addEventListener('submit', (event) => {
        if (typeof tinymce === 'undefined') {
            return;
        }

        const form = event.target;

        if (form?.querySelector?.('textarea.cms-builder-rich-editor')) {
            tinymce.triggerSave();
        }
    }, true);

    document.addEventListener('click', (e) => {
        const btn = e.target?.closest?.('.cms-locale-tab');

        if (! btn) {
            return;
        }

        const group = btn.getAttribute('data-tab-group');
        const tab = btn.getAttribute('data-tab');

        window.setTimeout(() => {
            const panel = document.querySelector(
                `.cms-locale-panel[data-tab-group="${group}"][data-tab-panel="${tab}"]`,
            );

            if (! panel) {
                return;
            }

            window.cmsBuilderInitRichEditors(panel);
            window.cmsBuilderResizeRichEditors(panel);
        }, 80);
    });
})();
</script>
@endPushOnce
