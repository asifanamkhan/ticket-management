<?php

return [

    /**
     *================================================================================
     * Profile ID
     *================================================================================.
     */
    'profile_id'      => env('PAYTABS_PROFILE_ID', '77461'),

    /**
     * Server Key.
     */
    'server_key'   => env('PAYTABS_SERVER_KEY', 'SKJNWNG2DB-J26L9GM96H-HN6MGK6TB9'),

    /**
     *================================================================================
     * Region ['ARE','EGY','SAU','OMN','JOR','GLOBAL']
     *================================================================================.
     */
    'region'        => env('PAYTABS_REGION', 'GLOBAL'),

    /**
     *================================================================================
     * Paytabs API Version
     *================================================================================.
     */
    'api_version'       => env('PAYTABS_API_VERSION', '2.0'),

    /**
     *================================================================================
     * CURRENCY ['AED','EGP','SAR','OMR','JOD','USD']
     *================================================================================.
     */

    'currency' => env('PAYTABS_CURRENCY', 'USD'),
];
