@php($placeholders = app('\Webkul\Automation\Helpers\Entity')->getEmailTemplatePlaceholders())

<v-tinymce {{ $attributes }}></v-tinymce>

@pushOnce('scripts')
    <!--
        TODO (@devansh-webkul): Only this portion is pending; it just needs to be integrated using the Vite bundler. Currently,
        there is an issue with relative paths in the plugins. I intend to address this task at the end.
    -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.6.2/tinymce.min.js"
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    ></script>

    <script
        type="text/x-template"
        id="v-tinymce-template"
    >
    </script>

    <script type="module">
        app.component('v-tinymce', {
            template: '#v-tinymce-template',

            props: {
                selector: {
                    type: String,
                    required: true,
                },
                field: {
                    type: Object,
                    required: true,
                },
                plugins: {
                    type: String,
                    default: 'image media wordcount save fullscreen code table lists link',
                },
                toolbar: {
                    type: String,
                    default: 'placeholders | bold italic strikethrough forecolor backcolor image alignleft aligncenter alignright alignjustify | link hr | numlist bullist outdent indent | removeformat | code | table',
                },
                showPlaceholders: {
                    type: Boolean,
                    default: true,
                },
                menubar: {
                    type: [String, Boolean],
                    default: false,
                },
                minHeight: {
                    type: Number,
                    default: 300,
                },
            },

            data() {
                return {
                    currentSkin: document.documentElement.classList.contains('dark') ? 'oxide-dark' : 'oxide',

                    currentContentCSS: document.documentElement.classList.contains('dark') ? 'dark' : 'default',

                    isLoading: false,
                };
            },

            mounted() {
                this.destroyTinymceInstance();

                this.waitAndInit();

                this.$emitter.on('change-theme', (theme) => {
                    this.destroyTinymceInstance();

                    this.currentSkin = (theme === 'dark') ? 'oxide-dark' : 'oxide';
                    this.currentContentCSS = (theme === 'dark') ? 'dark' : 'default';

                    this.waitAndInit();
                });
            },

            methods: {
                editorId() {
                    return (this.selector || '').replace(/^textarea#/, '');
                },

                destroyTinymceInstance() {
                    if (typeof tinymce === 'undefined') {
                        return;
                    }

                    const id = this.editorId();

                    if (! id) {
                        return;
                    }

                    const editor = tinymce.get(id);

                    if (editor) {
                        editor.remove();
                    }
                },

                waitAndInit(attempts = 0) {
                    if (typeof tinymce !== 'undefined') {
                        this.$nextTick(() => this.init());

                        return;
                    }

                    if (attempts < 50) {
                        window.setTimeout(() => this.waitAndInit(attempts + 1), 100);
                    }
                },

                init() {
                    const target = document.querySelector(this.selector);

                    if (! target) {
                        return;
                    }

                    if (this.editorId() && tinymce.get(this.editorId())) {
                        return;
                    }

                    let self = this;

                    let tinyMCEHelper = {
                        initTinyMCE: function(extraConfiguration) {
                            let self2 = this;

                            let config = {
                                relative_urls: false,
                                menubar: false,
                                remove_script_host: false,
                                document_base_url: '{{ asset('/') }}',
                                uploadRoute: '{{ route('admin.tinymce.upload') }}',
                                csrfToken: '{{ csrf_token() }}',
                                ...extraConfiguration,
                                skin: self.currentSkin,
                                content_css: self.currentContentCSS,
                            };

                            const image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
                                self2.uploadImageHandler(config, blobInfo, resolve, reject, progress);
                            });

                            tinymce.init({
                                ...config,

                                file_picker_callback: function(cb, value, meta) {
                                    self2.filePickerCallback(config, cb, value, meta);
                                },

                                images_upload_handler: image_upload_handler,
                            });
                        },

                        filePickerCallback: function(config, cb, value, meta) {
                            let input = document.createElement('input');
                            input.setAttribute('type', 'file');
                            input.setAttribute('accept', 'image/*');

                            input.onchange = function() {
                                let file = this.files[0];

                                let reader = new FileReader();
                                reader.readAsDataURL(file);
                                reader.onload = function() {
                                    let id = 'blobid' + new Date().getTime();
                                    let blobCache = tinymce.activeEditor.editorUpload.blobCache;
                                    let base64 = reader.result.split(',')[1];
                                    let blobInfo = blobCache.create(id, file, base64);

                                    blobCache.add(blobInfo);

                                    cb(blobInfo.blobUri(), {
                                        title: file.name
                                    });
                                };
                            };

                            input.click();
                        },

                        uploadImageHandler: function(config, blobInfo, resolve, reject, progress) {
                            let xhr, formData;

                            xhr = new XMLHttpRequest();

                            xhr.withCredentials = false;

                            xhr.open('POST', config.uploadRoute);

                            xhr.upload.onprogress = ((e) => progress((e.loaded / e.total) * 100));

                            xhr.onload = function() {
                                let json;

                                if (xhr.status === 403) {
                                    reject("@lang('admin::app.components.tiny-mce.http-error')", {
                                        remove: true
                                    });

                                    return;
                                }

                                if (xhr.status < 200 || xhr.status >= 300) {
                                    reject("@lang('admin::app.components.tiny-mce.http-error')");

                                    return;
                                }

                                json = JSON.parse(xhr.responseText);

                                if (! json || typeof json.location != 'string') {
                                    reject("@lang('admin::app.components.tiny-mce.invalid-json')" + xhr.responseText);

                                    return;
                                }

                                resolve(json.location);
                            };

                            xhr.onerror = (()=>reject("@lang('admin::app.components.tiny-mce.upload-failed')"));

                            formData = new FormData();
                            formData.append('_token', config.csrfToken);
                            formData.append('file', blobInfo.blob(), blobInfo.filename());

                            xhr.send(formData);
                        },
                    };

                    const selfComponent = this;

                    const defaultPlugins = 'image media wordcount save fullscreen code table lists link';
                    const defaultToolbar = 'placeholders | bold italic strikethrough forecolor backcolor image alignleft aligncenter alignright alignjustify | link hr | numlist bullist outdent indent | removeformat | code | table';

                    tinyMCEHelper.initTinyMCE({
                        selector: this.selector,
                        plugins: this.plugins || defaultPlugins,
                        toolbar: this.toolbar || defaultToolbar,
                        menubar: this.menubar || false,
                        min_height: this.minHeight || 300,
                        image_advtab: true,
                        directionality: document.documentElement.getAttribute('dir') || 'ltr',
                        promotion: false,
                        branding: false,
                        setup: (editor) => {
                            if (selfComponent.showPlaceholders) {
                                editor.ui.registry.addMenuButton('placeholders', {
                                    text: 'Placeholders',
                                    fetch: function (callback) {
                                        const items = [
                                            @foreach($placeholders as $placeholder)
                                                {
                                                    type: 'nestedmenuitem',
                                                    text: '{{ $placeholder['text'] }}',
                                                    getSubmenuItems: () => [
                                                        @foreach($placeholder['menu'] as $child)
                                                            {
                                                                type: 'menuitem',
                                                                text: '{{ $child['text'] }}',
                                                                onAction: function () {
                                                                    editor.insertContent('{{ $child['value'] }}');
                                                                },
                                                            },
                                                        @endforeach
                                                    ],
                                                },
                                            @endforeach
                                        ];

                                        callback(items);
                                    }
                                });
                            }

                            editor.on('init', () => {
                                if (selfComponent.field?.value) {
                                    editor.setContent(selfComponent.field.value);
                                }
                            });

                            ['change', 'paste', 'keyup'].forEach((event) => {
                                editor.on(event, () => selfComponent.field.onInput(editor.getContent()));
                            });
                        }
                    });
                },
            },
        })
    </script>
@endPushOnce
