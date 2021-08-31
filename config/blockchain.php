<?php
return [
    'enabled'=>env('BLOCKCHAIN_ENABLED'),
    'hash_algo'=>env('BLOCKCHAIN_HASH_ALGORITHM'),
    'hash_salt'=>env('BLOCKCHAIN_HASH_SALT'),
    'difficulty' => env('BLOCKCHAIN_DIFFICULTY')
];
