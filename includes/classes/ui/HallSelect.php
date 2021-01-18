<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PureOSC\ui;

/**
 * Description of HallSelect
 *
 * @author vitex
 */
class HallSelect extends \Ease\Html\SelectTag {

    public function __construct($defaultValue = null, $properties = []) {
        $haller = new \PureOSC\Hall();
        $halls = [''=>'none'];
        foreach ($haller->getHalls() as $hallData) {
            $halls[$hallData['id']] = $hallData['name'] . ' ' . $hallData['capacity'];
        }
        parent::__construct('hall', $halls, $defaultValue, $properties);
    }

}
