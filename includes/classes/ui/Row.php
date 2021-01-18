<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PureOSC\ui;

use Ease\Html\DivTag;
use Ease\Html\SpanTag;
use PureOSC\ui\Chair;

/**
 * Description of Row
 *
 * @author vitex
 */
class Row extends DivTag {

    public $chairs = 10;

    public function __construct($rowNumber = null, int $chairs, $properties = []) {
        $this->chairs = $chairs;
        parent::__construct(new SpanTag($rowNumber, ['class' => 'rownumber']), $properties);
        $this->populate($rowNumber);
    }

    public function populate($rowNumber) {
        foreach (array_keys(array_fill(0, $this->chairs, true)) as $chair) {
            $this->addItem(new Chair($chair, $rowNumber . '/' . $chair, ['row' => $rowNumber]));
        }
    }


}
