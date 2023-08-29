<?php

return [

    /**
     * Konfigurasi untuk halaman portal statistic
     */
    'statistik' => [

        /**
         * Centralized cache
         */
        'cache' => [

            /**
             * lifetime in seconds
             */
            'lifetime' => env('KPKB_STATISTIK_CACHE_LIFETIME', 300)
        ]
    ]
];