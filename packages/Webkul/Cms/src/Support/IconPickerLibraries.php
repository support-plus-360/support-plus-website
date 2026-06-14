<?php

namespace Webkul\Cms\Support;

class IconPickerLibraries
{
    /**
     * @return array<string, array{label_key: string, stylesheet?: string, icons: array<int, string>}>
     */
    public static function all(): array
    {
        return [
            'icomoon' => [
                'label_key' => 'cms::app.icon-picker.tabs.icomoon',
                'icons'     => [
                    'icon-cms', 'icon-mail', 'icon-user', 'icon-profile', 'icon-contact', 'icon-leads',
                    'icon-organization', 'icon-activity', 'icon-attribute', 'icon-bookmark', 'icon-bookmark-active',
                    'icon-calendar', 'icon-call', 'icon-meeting', 'icon-message', 'icon-note', 'icon-video',
                    'icon-attachment', 'icon-attached-file', 'icon-forward', 'icon-reply', 'icon-reply-all',
                    'icon-sent', 'icon-notification', 'icon-configuration', 'icon-setting', 'icon-filter', 'icon-search',
                    'icon-add', 'icon-add-2', 'icon-edit', 'icon-delete', 'icon-dashboard', 'icon-kanban', 'icon-list',
                    'icon-enter', 'icon-move', 'icon-location', 'icon-pin', 'icon-print', 'icon-tag', 'icon-stats-down',
                    'icon-stats-up', 'icon-file', 'icon-folder', 'icon-image', 'icon-product', 'icon-rotten',
                    'icon-percentage', 'icon-dollar', 'icon-quote', 'icon-perosnal', 'icon-system-generate', 'icon-download',
                    'icon-info', 'icon-error', 'icon-success', 'icon-warning', 'icon-eye', 'icon-eye-hide',
                    'icon-left-arrow', 'icon-right-arrow', 'icon-up-arrow', 'icon-down-arrow', 'icon-menu', 'icon-more',
                    'icon-tick', 'icon-cross-large', 'icon-restore', 'icon-forceDelete', 'icon-settings-mail',
                    'icon-settings-group', 'icon-settings-webforms', 'icon-light', 'icon-dark', 'icon-checkbox-outline',
                    'icon-checkbox-select', 'icon-radio-selected', 'icon-radio-normal',
                ],
            ],
            'fontawesome' => [
                'label_key'   => 'cms::app.icon-picker.tabs.fontawesome',
                'stylesheet'  => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
                'icons'       => [
                    'fa-solid fa-headset', 'fa-solid fa-phone', 'fa-solid fa-phone-volume', 'fa-solid fa-envelope',
                    'fa-solid fa-envelope-open-text', 'fa-solid fa-user', 'fa-solid fa-users', 'fa-solid fa-user-tie',
                    'fa-solid fa-building', 'fa-solid fa-city', 'fa-solid fa-briefcase', 'fa-solid fa-handshake',
                    'fa-solid fa-chart-line', 'fa-solid fa-chart-pie', 'fa-solid fa-chart-bar', 'fa-solid fa-chart-simple',
                    'fa-solid fa-gears', 'fa-solid fa-screwdriver-wrench', 'fa-solid fa-sliders', 'fa-solid fa-shield-halved',
                    'fa-solid fa-lock', 'fa-solid fa-unlock', 'fa-solid fa-globe', 'fa-solid fa-language', 'fa-solid fa-comments',
                    'fa-solid fa-comment-dots', 'fa-solid fa-message', 'fa-solid fa-lightbulb', 'fa-solid fa-rocket',
                    'fa-solid fa-star', 'fa-solid fa-heart', 'fa-solid fa-check', 'fa-solid fa-circle-check',
                    'fa-solid fa-xmark', 'fa-solid fa-plus', 'fa-solid fa-minus', 'fa-solid fa-arrow-right',
                    'fa-solid fa-arrow-left', 'fa-solid fa-cloud', 'fa-solid fa-server', 'fa-solid fa-database',
                    'fa-solid fa-code', 'fa-solid fa-laptop', 'fa-solid fa-mobile-screen', 'fa-solid fa-wifi',
                    'fa-solid fa-bell', 'fa-solid fa-calendar-days', 'fa-solid fa-clock', 'fa-solid fa-map-pin',
                    'fa-solid fa-location-dot', 'fa-solid fa-truck-fast', 'fa-solid fa-cart-shopping', 'fa-solid fa-credit-card',
                    'fa-solid fa-dollar-sign', 'fa-solid fa-percent', 'fa-solid fa-tags', 'fa-solid fa-folder',
                    'fa-solid fa-file', 'fa-solid fa-image', 'fa-solid fa-video', 'fa-solid fa-camera',
                    'fa-solid fa-microphone', 'fa-solid fa-pen', 'fa-solid fa-pencil', 'fa-solid fa-trash',
                    'fa-solid fa-download', 'fa-solid fa-upload', 'fa-solid fa-magnifying-glass', 'fa-solid fa-filter',
                    'fa-brands fa-google', 'fa-brands fa-facebook', 'fa-brands fa-facebook-f', 'fa-brands fa-twitter',
                    'fa-brands fa-x-twitter', 'fa-brands fa-linkedin', 'fa-brands fa-linkedin-in', 'fa-brands fa-instagram',
                    'fa-brands fa-youtube', 'fa-brands fa-whatsapp', 'fa-brands fa-telegram', 'fa-brands fa-github',
                    'fa-brands fa-microsoft', 'fa-brands fa-apple', 'fa-brands fa-android',
                ],
            ],
            'bootstrap' => [
                'label_key'   => 'cms::app.icon-picker.tabs.bootstrap',
                'stylesheet'  => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
                'icons'       => [
                    'bi bi-headset', 'bi bi-telephone', 'bi bi-telephone-fill', 'bi bi-envelope', 'bi bi-envelope-fill',
                    'bi bi-person', 'bi bi-people', 'bi bi-person-badge', 'bi bi-building', 'bi bi-briefcase',
                    'bi bi-briefcase-fill', 'bi bi-handshake', 'bi bi-graph-up', 'bi bi-graph-up-arrow', 'bi bi-pie-chart',
                    'bi bi-bar-chart', 'bi bi-bar-chart-line', 'bi bi-gear', 'bi bi-gear-fill', 'bi bi-sliders',
                    'bi bi-shield-check', 'bi bi-shield-lock', 'bi bi-lock', 'bi bi-unlock', 'bi bi-globe',
                    'bi bi-translate', 'bi bi-chat', 'bi bi-chat-dots', 'bi bi-chat-left-text', 'bi bi-lightbulb',
                    'bi bi-lightbulb-fill', 'bi bi-rocket', 'bi bi-rocket-takeoff', 'bi bi-star', 'bi bi-star-fill',
                    'bi bi-heart', 'bi bi-heart-fill', 'bi bi-check-lg', 'bi bi-check-circle', 'bi bi-x-lg',
                    'bi bi-plus-lg', 'bi bi-dash-lg', 'bi bi-arrow-right', 'bi bi-arrow-left', 'bi bi-cloud',
                    'bi bi-cloud-fill', 'bi bi-hdd-stack', 'bi bi-database', 'bi bi-code-slash', 'bi bi-laptop',
                    'bi bi-phone', 'bi bi-wifi', 'bi bi-bell', 'bi bi-bell-fill', 'bi bi-calendar-event',
                    'bi bi-clock', 'bi bi-clock-fill', 'bi bi-geo-alt', 'bi bi-pin-map', 'bi bi-truck',
                    'bi bi-cart', 'bi bi-cart-fill', 'bi bi-credit-card', 'bi bi-currency-dollar', 'bi bi-percent',
                    'bi bi-tags', 'bi bi-tag', 'bi bi-folder', 'bi bi-folder-fill', 'bi bi-file-earmark',
                    'bi bi-image', 'bi bi-camera', 'bi bi-camera-video', 'bi bi-mic', 'bi bi-pencil',
                    'bi bi-pencil-square', 'bi bi-trash', 'bi bi-trash-fill', 'bi bi-download', 'bi bi-upload',
                    'bi bi-search', 'bi bi-funnel', 'bi bi-google', 'bi bi-facebook', 'bi bi-twitter',
                    'bi bi-linkedin', 'bi bi-instagram', 'bi bi-youtube', 'bi bi-whatsapp', 'bi bi-github',
                ],
            ],
        ];
    }
}
