<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PureOSC;

/**
 * Description of Engine
 *
 * @author vitex
 */
class Engine extends \Ease\SQL\Engine {

    public function __construct($identifier = null, $options = []) {
        parent::__construct($identifier, array_merge(self::cfg(), $options));
    }

    static function cfg() {
        return ['dbType' => constant('DB_CONNECTION'),
            'server' => constant('DB_SERVER'),
            'username' => constant('DB_SERVER_USERNAME'),
            'password' => constant('DB_SERVER_PASSWORD'),
            'database' => constant('DB_DATABASE'),
            'port' => constant('DB_SERVER_PORT')
        ];
    }

}
