<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PureOSC\ui;

/**
 * Description of HallEditor
 *
 * @author vitex
 */
class HallEditor extends Hall {

    public function __construct($hallEngine, $properties = []) {
        parent::__construct($hallEngine->getDataValue('name'), [], $properties);
        $this->segments = $hallEngine->getSegments();

        $this->addItem(new HallForm($hallEngine->getData()));

        if ($this->name) {
            $this->addItem(new \Ease\TWB4\LinkButton('segment.php', 'Add Segment', 'warning'));
        }
    }

    public function addSegment(string $code) {
        $segmentor = new Segments(Segment::uncode($code));
        if ($segmentor->dbSync()) {
            $this->segments[$segmentInfo['name']] = $segmentor->getData();
        }
    }
    public function delSegment($segName) {
        unset($this->segments[$segName]);
        unset($_SESSION['hall'][$this->name][$segName]);
    }


    public function empty() {
        $this->segments[$segmentInfo['name']] = [];
        $_SESSION['hall'][$this->name] = [];
    }

    public function finalize() {
        $seats = 0;
        foreach ($this->segments as $segName => $size) {
            if ($segName) {
                $rows = (int) key($size);
                $cols = (int) current($size);
                $seg = new Segment($segName, $rows, $cols);
                $seg->finalize();
                $this->addItem($seg);
                $this->addItem(new \Ease\TWB4\LinkButton('hall.php?del_segment=' . $segName, 'X', 'danger'), $size);
                $seats += $rows * $cols;
            }
        }
        $this->addItem( new \Ease\Html\DivTag('Total seats in hall ' . $seats) );
        parent::finalize();
    }

}
