@php
    use Webkul\Cms\Support\IconPickerLibraries;

    $libraries = IconPickerLibraries::all();
@endphp

@pushOnce('styles', 'cms.icon-picker.libraries')
    @foreach ($libraries as $library)
        @if (! empty($library['stylesheet']))
            <link rel="stylesheet" href="{{ $library['stylesheet'] }}" crossorigin="anonymous" referrerpolicy="no-referrer" />
        @endif
    @endforeach
    <style>
        .cms-icon-picker-overlay {
            position: fixed;
            inset: 0;
            z-index: 10050;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1rem;
        }

        .cms-icon-picker-overlay.is-open {
            display: flex;
        }

        .cms-icon-picker-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            border: 0;
            cursor: pointer;
        }

        .cms-icon-picker-dialog {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 36rem;
            height: 480px;
            max-height: min(68vh, 480px);
            border-radius: 0.5rem;
            background: #fff;
            color: #1f2937;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        .dark .cms-icon-picker-dialog {
            background: #111827;
            color: #e5e7eb;
        }

        .cms-icon-picker-header {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.625rem 1rem;
        }

        .dark .cms-icon-picker-header {
            border-bottom-color: #1f2937;
        }

        .cms-icon-picker-toolbar {
            flex-shrink: 0;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.625rem 1rem;
        }

        .dark .cms-icon-picker-toolbar {
            border-bottom-color: #1f2937;
        }

        .cms-icon-picker-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 0.375rem;
            margin-bottom: 0.5rem;
        }

        .cms-icon-picker-tab {
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            padding: 0.25rem 0.625rem;
            font-size: 0.75rem;
            font-weight: 500;
            color: #374151;
            background: transparent;
            cursor: pointer;
        }

        .cms-icon-picker-tab:hover {
            background: #f9fafb;
        }

        .dark .cms-icon-picker-tab {
            border-color: #374151;
            color: #e5e7eb;
        }

        .dark .cms-icon-picker-tab:hover {
            background: #1f2937;
        }

        .cms-icon-picker-tab-active {
            border-color: rgb(59, 130, 246);
            background-color: rgb(243, 244, 246);
            color: rgb(17, 24, 39);
        }

        .dark .cms-icon-picker-tab-active {
            background-color: rgb(3, 7, 18);
            color: #fff;
            border-color: rgb(96, 165, 250);
        }

        .cms-icon-picker-search {
            width: 100%;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }

        .dark .cms-icon-picker-search {
            border-color: #374151;
            background: #1f2937;
            color: #e5e7eb;
        }

        .cms-icon-picker-body {
            flex: 1;
            min-height: 0;
            overflow: hidden;
        }

        .cms-icon-picker-panel {
            height: 100%;
            overflow-y: auto;
            padding: 0.5rem 0.75rem;
        }

        .cms-icon-picker-panel.is-hidden {
            display: none;
        }

        .cms-icon-picker-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 0.375rem;
        }

        @media (min-width: 640px) {
            .cms-icon-picker-grid {
                grid-template-columns: repeat(6, minmax(0, 1fr));
            }
        }

        @media (min-width: 768px) {
            .cms-icon-picker-grid {
                grid-template-columns: repeat(7, minmax(0, 1fr));
            }
        }

        .cms-icon-picker-icon-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            aspect-ratio: 1;
            border: 1px solid #e5e7eb;
            border-radius: 0.25rem;
            color: #374151;
            background: transparent;
            cursor: pointer;
            padding: 0;
        }

        .cms-icon-picker-icon-btn:hover {
            border-color: #60a5fa;
            background: #eff6ff;
        }

        .cms-icon-picker-icon-btn.is-hidden {
            display: none;
        }

        .dark .cms-icon-picker-icon-btn {
            border-color: #374151;
            color: #e5e7eb;
        }

        .dark .cms-icon-picker-icon-btn:hover {
            border-color: #3b82f6;
            background: #1f2937;
        }

        .cms-icon-picker-icon-btn i {
            font-size: 1.125rem;
            line-height: 1;
        }

        .cms-icon-picker-close-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            border: 0;
            border-radius: 0.25rem;
            background: transparent;
            cursor: pointer;
        }

        .cms-icon-picker-close-btn:hover {
            background: #f3f4f6;
        }

        .dark .cms-icon-picker-close-btn:hover {
            background: #1f2937;
        }
    </style>
@endPushOnce
