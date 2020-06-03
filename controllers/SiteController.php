<?php

namespace app\controllers;

use app\controllers\BaseController;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends BaseController
{
    /**
     * Displays homepage.
     */
    public function actionIndex()
    {
        return [
            'title' => 'Listado de endpoints',
            'endpoints' => [
                [
                    'method' => 'GET',
                    'uri' => '/modem/list',
                    'params' => []
                ],

                [
                    'method' => 'GET',
                    'uri' => '/modem/list/{macaddress}',
                    'params' => [
                        'macaddress' => 'Modem Mac address',
                    ]
                ],
                [
                    'method' => 'GET',
                    'uri' => '/modem/list/vendor/{vendor}',
                    'params' => [
                        'vendor' => 'Vendor name/alias'
                    ]
                ],
                [
                    'method' => 'GET',
                    'uri' => '/modem/list/vendor/{vendor}/empty',
                    'params' => [
                        'vendor' => 'Vendor name/alias'
                    ]
                ],
                [
                    'method' => 'POST',
                    'uri' => '/modem/add',
                    'body' => '{macaddress}',
                    'params' => [
                        'macaddress' => 'Modem Mac address',
                    ]
                ],
            ]
        ];
    }
}
