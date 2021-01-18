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
    public $seatsPerRow;
    public $posInHall;
    private $name;

    public function __construct(string $name, int $rows, int $seatsPerRow, string $posInHall = '') {
        parent::__construct(null, []);

        $this->name = $name;
        $this->rows = $rows;
        $this->seatsPerRow = $seatsPerRow;
        $this->posInHall = $posInHall;
        $this->populate();
    }

    public function populate() {
        $this->addItem(new \Ease\Html\H5Tag($this->name . ': ' . $this->rows . ' x ' . $this->seatsPerRow . ' = ' . ($this->rows * $this->seatsPerRow )));
        foreach (array_keys(array_fill(0, $this->rows, true)) as $row) {
            $this->addItem(new Row($row + 1, $this->seatsPerRow));
        }
    }

    public static function code($name, $rows, $cols) {
        return $name . '|' . $rows . 'x' . $cols;
    }

    public static function uncode(string $code) {
        list($name, $size) = explode('|', $code);
        list($rows, $cols) = explode('x', $size);
        return ['name' => $name, 'rows' => $rows, 'cols' => $cols];
    }

    public function seats() {
        return $this->rows * $this->seatsPerRow;
    }

}
