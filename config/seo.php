<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default OG / Twitter image (relative to public/ or full URL)
    |--------------------------------------------------------------------------
    | Used when a page has no featured image. Falls back to Setting seo_og_image.
    */
    'default_image' => env('SEO_DEFAULT_IMAGE', '/darponbdv.png'),

    'max_meta_description_length' => 320,

    'max_og_description_length' => 300,
];
