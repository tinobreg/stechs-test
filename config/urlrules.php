<?php
return [
    '/' =>'site/index',

    'OPTIONS modem/list' => 'modem/list',
    'OPTIONS modem/list/<mac:\w+>' => 'modem/list',
    'OPTIONS modem/list/vendor/<vendor:[\w-]+>/' => 'modem/list-by-vendor',
    'OPTIONS modem/list/vendor/<vendor:[\w-]+>/empty' => 'modem/no-match',
    'OPTIONS modem/add' => 'modem/add-modem',

    'GET modem/list' => 'modem/list',
    'GET modem/list/<mac:\w+>' => 'modem/list',
    'GET modem/list/vendor/<vendor:[\w-]+>/' => 'modem/list-by-vendor',
    'GET modem/list/vendor/<vendor:[\w-]+>/empty' => 'modem/no-match',
    'POST modem/add' => 'modem/add-modem',
];