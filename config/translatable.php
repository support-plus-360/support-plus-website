<?php

use Astrotomic\Translatable\Validation\RuleFactory;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Locales
    |--------------------------------------------------------------------------
    |
    | Astrotomic only persists translation payloads for locales listed here.
    | Keep this aligned with config('app.available_locales') so Arabic (ar)
    | and other admin languages are actually saved to translation tables.
    |
    */
    'locales' => array_keys(config('app.available_locales', [
        'en' => 'English',
        'ar' => 'Arabic',
    ])),

    'locale_separator' => '-',

    'locale' => null,

    'use_fallback' => false,

    'use_property_fallback' => true,

    'fallback_locale' => 'en',

    'translation_model_namespace' => null,

    'translation_suffix' => 'Translation',

    'locale_key' => 'locale',

    'to_array_always_loads_translations' => true,

    'rule_factory' => [
        'format' => RuleFactory::FORMAT_ARRAY,
        'prefix' => '%',
        'suffix' => '%',
    ],

    'translations_wrapper' => null,
];
