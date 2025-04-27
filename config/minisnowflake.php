<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Snowflake Epoch
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for snowflake. Set the date
    | the application was develop started. Don't set the date of the future.
    | If service starts to move, don't change.
    |
    | Available Settings: Y-m-d H:i:s
    |
    */
    'epoch' => env('MINISNOWFLAKE_EPOCH', '2025-04-01 00:00:00'),
];
