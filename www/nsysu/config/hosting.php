<?php

return [
    'upload_to_hosting' => env('UPLOAD_TO_HOSTING', false),
    
    'smugmug' => [
        'album_uri' => env('SMUGMUG_ALBUM_URI', ''),
        
        'oauth_secret' => env('SMUGMUG_OAUTH_SECRET', ''),
        
        'oauth_api_key' => env('SMUGMUG_OAUTH_API_KEY', ''),
        
        'access_token' => env('SMUGMUG_ACCESS_TOKEN', ''),
        
        'access_token_secret' => env('SMUGMUG_ACCESS_TOKEN_SECRET', ''),
    ],
];
