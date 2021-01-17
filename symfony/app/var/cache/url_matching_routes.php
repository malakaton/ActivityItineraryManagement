<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/' => [[['_route' => 'index', '_controller' => 'Itinerary\\App\\Controller\\IndexController'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/itineraries/([^/]++)/activity(?'
                    .'|(*:75)'
                .')'
            .')/?$}sD',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        75 => [
            [['_route' => 'activities_itinerary_get_by_id', 'auth' => false, '_controller' => 'Academy\\ActivityItinerary\\EntryPoint\\Http\\Controller\\GetActivitiesByItineraryUuidController'], ['id'], ['GET' => 0, 'HEAD' => 1], null, false, false, null],
            [['_route' => 'itinerary_store_activity', 'auth' => false, '_controller' => 'Academy\\ActivityItinerary\\EntryPoint\\Http\\Controller\\AddActivityItineraryController'], ['id'], ['POST' => 0], null, false, false, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
