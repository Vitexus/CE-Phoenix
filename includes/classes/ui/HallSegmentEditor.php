<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PureOSC\ui;

/**
 * Description of HallLayout
 *
 * @author vitex
 */
class HallSegmentEditor extends \Ease\Html\DivTag {

    public $name = 'Unnamed';

    public function __construct($content = null, $properties = []) {
        parent::__construct($content, $properties);

        $layoutForm = new SegmentLayoutForm();
        
        $this->addItem($layoutForm);

//        $this->addItem($layoutForm);
    }

}
