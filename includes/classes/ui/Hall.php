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
    public $segments = [];

    public function __construct($hallName, $segments = [], $properties = []) {
        $this->name = $hallName;
        $this->segments = $segments;
        parent::__construct(new \Ease\Html\H1Tag($this->name), $properties);
        $this->populate();
    }

    public function segments() {
        return empty($this->segments) ? [] : $this->segments;
    }

    public function populate($properties = []) {
        foreach ($this->segments() as $segment => $geometry) {
            $this->addItem(new Segment($segment, key($geometry), current($geometry)));
        }
    }

    public function seats() {
        $seats = 0;
        foreach ($this->segments() as $segment) {
            $seats += key($segment) * current($segment);
        }
        return $seats;
    }

    public function updateTickets() {
        
    }

}
