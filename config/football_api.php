<?php

return [
    'base_url' => env('FOOTBALL_API_BASE_URL', 'https://api.football-data.org/v2/'),
    'key'      => env('FOOTBALL_API_KEY', ""),
    'timeout'  => 10,
    'retries'  => 2,
];