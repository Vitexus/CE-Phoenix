<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PureOSC\ui;

/**
 * Description of HallForm
 *
 * @author vitex
 */
class HallForm extends \Ease\TWB4\Form {

    public function __construct($data = []) {
        parent::__construct();

        $this->addInput(new \Ease\Html\InputTextTag('hall_name', array_key_exists('name', $data) ? $data['name'] : '', ['id' => 'hallname', 'required']), 'Hall name');
        $this->addInput(new \Ease\Html\InputNumberTag('hall_capacity', array_key_exists('capacity', $data) ? $data['capacity'] : 1, ['id' => 'hallmax', 'min' => 1]), 'Hall maximum capacity');

        if (array_key_exists('id', $data)) {
            $this->addItem(new \Ease\Html\InputHiddenTag('id', $data['id']));
            $this->addInput(new \Ease\TWB4\SubmitButton('Update Hall', 'success'));
        } else {
            $this->addInput(new \Ease\TWB4\SubmitButton('Save new Hall', 'success'));
        }
    }

}
