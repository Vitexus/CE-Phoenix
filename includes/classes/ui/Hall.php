<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PureOSC\ui;

use Ease\Html\DivTag;

/**
 * Description of Hall
 *
 * @author vitex
 */
class Hall extends DivTag {

    public $rows = 5;
    public $name = '';

    public function __construct($hallName, $properties = []) {
        $this->name = $hallName;
        parent::__construct(new \Ease\Html\H1Tag($this->name), $properties);
        $this->populate();
    }

    public function segments() {
        return [['name'=>'defaul']];
    }
    
    public function populate( ) {
        foreach ($this->segments() as $segment) {
            $this->addItem(new Segment($segment['name'],4,4));
        }
    }

}
