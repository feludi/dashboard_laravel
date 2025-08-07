<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Maps API Key
    |--------------------------------------------------------------------------
    |
    | This is your Google Maps API key. You can get one from:
    | https://developers.google.com/maps/documentation/javascript/get-api-key
    |
    */
    'api_key' => env('GOOGLE_MAPS_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Google Maps Default Configuration
    |--------------------------------------------------------------------------
    |
    | Default configuration for Google Maps integration
    |
    */
    'default_center' => [
        'lat' => -6.2088,  // Jakarta coordinates
        'lng' => 106.8456,
    ],

    'default_zoom' => 13,

    /*
    |--------------------------------------------------------------------------
    | Google Maps Libraries
    |--------------------------------------------------------------------------
    |
    | Additional Google Maps libraries to load
    |
    */
    'libraries' => [
        'places',  // For places autocomplete
        'geometry', // For geometry calculations
    ],
];
