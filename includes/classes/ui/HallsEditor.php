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
class HallsEditor extends \Ease\Html\DivTag {

    private $name;
    private $halls;
    private $hallEngine;

    public function __construct($halls = null, $properties = []) {
        if (is_array($halls)) {
            $this->halls = $halls;
        } else {
            $this->halls = $halls->getAll();
        }
        parent::__construct('', [], $properties);
    }

    public function hallList() {
        $seats = 0;

        foreach ($this->halls as $hallInfo) {
            $hallBlock = new \Ease\TWB4\Card(new \Ease\Html\H1Tag(new \Ease\Html\ATag('hall.php?id=' . $hallInfo['id'], $hallInfo['name'])));
            $hall = new Hall('', $hallInfo['segments']);
            $hall->finalize();
            $hallSeats = $hall->seats();
            $capacity = $hallInfo['capacity'];
            if ($capacity == $hallSeats) {
                $state = 'success';
            } elseif ($capacity < $hallSeats) {
                $state = 'danger';
            } else {
                $state = 'warning';
            }
            $hallBlock->addItem(new \Ease\TWB4\Label($state, 'Hall capacity: ' . $capacity . ' Defined Capacity: ' . $hallSeats));
            $seats += $hallSeats;

            $hallBlock->addItem($hall);
            if (empty($hallInfo['segments'])) {
                $hallBlock->addItem('No Segments defined');
                $hallBlock->addItem(new \Ease\TWB4\LinkButton('halls.php?del_hall=' . $hallInfo['id'], 'Remove Hall <strong>' . $hallInfo['name'] . '</strong>', 'danger'));
            }

            $this->addItem($hallBlock);
        }
        $this->addItem(new \Ease\Html\DivTag('Total seats in halls ' . $seats));
    }

    public function addHall(string $name) {
        $this->halls[$name] = [];
        $_SESSION['hall'] = $this->halls;
    }

    public function delHall($hallName) {
        unset($this->halls[$hallName]);
        unset($_SESSION['hall'][$hallName]);
    }

    public function empty() {
        $this->halls = [];
        $_SESSION['hall'] = [];
    }

    public function finalize() {
        $this->hallList();
        parent::finalize();
    }

}
