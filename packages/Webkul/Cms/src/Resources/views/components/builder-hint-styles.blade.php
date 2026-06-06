@pushOnce('styles', 'cms.builder.hint-tooltip')
    <style>
        .cms-builder-hint {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            vertical-align: middle;
            cursor: help;
            outline: none;
        }
        .cms-builder-hint__bubble {
            position: absolute;
            z-index: 10040;
            left: 50%;
            bottom: calc(100% + 8px);
            transform: translateX(-50%);
            width: max-content;
            max-width: min(280px, 70vw);
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            border: 1px solid rgb(229 231 235);
            background: rgb(255 255 255);
            box-shadow: 0 4px 14px rgb(0 0 0 / 0.12);
            font-size: 0.75rem;
            font-weight: 400;
            line-height: 1.4;
            color: rgb(55 65 81);
            text-align: start;
            white-space: normal;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.15s ease, visibility 0.15s ease;
        }
        .dark .cms-builder-hint__bubble {
            border-color: rgb(55 65 81);
            background: rgb(31 41 55);
            color: rgb(229 231 235);
            box-shadow: 0 4px 14px rgb(0 0 0 / 0.35);
        }
        .cms-builder-hint:hover .cms-builder-hint__bubble,
        .cms-builder-hint:focus .cms-builder-hint__bubble,
        .cms-builder-hint:focus-within .cms-builder-hint__bubble {
            opacity: 1;
            visibility: visible;
        }
        .cms-builder-field-group {
            overflow: visible;
        }
        .cms-builder-field-group__title {
            margin: 0 0 0.75rem;
            font-size: 0.8125rem;
            font-weight: 600;
            color: rgb(31 41 55);
        }
        .dark .cms-builder-field-group__title {
            color: rgb(243 244 246);
        }
        .cms-builder-field-group__help {
            margin: -0.25rem 0 0.75rem;
            font-size: 0.75rem;
            color: rgb(107 114 128);
        }
        .dark .cms-builder-field-group__help {
            color: rgb(156 163 175);
        }
    </style>
@endPushOnce
