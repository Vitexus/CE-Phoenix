<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PureOSC\ui;

use Ease\Html\DivTag;

/**
 * Description of Segment
 *
 * @author vitex
 */
class Segment extends DivTag {

    public $hall;
    public $rows;
    public $satsPerRow;
    public $posInHall;

    public function __construct(string $name, int $rows, int $seatsPerRow, string $posInHall = '') {
        parent::__construct(null,[]);
        $this->populate($rows, $seatsPerRow);
    }

    public function populate(int $rows, $seatsPerRow) {
        foreach (array_keys(array_fill(0, $rows, true)) as $row) {
            $this->addItem(new Row($row + 1, $seatsPerRow));
        }
    }

}
