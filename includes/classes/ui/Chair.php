<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PureOSC\ui;

use chillerlan\QRCode\QRCode;
use Ease\Html\ImgTag;
use Ease\TWB4\Label;

/**
 * Description of Chair
 *
 * @author vitex
 */
class Chair extends ImgTag {

    public $number;
    public $row;
    public $occupied = false;
    public $order = null;
    public $chairImage = 'apps/hall/chair.svg';

    public function __construct($number, $alt = null, $tagProperties = []) {
        $tagProperties['style'] = 'width: 9%;';
        $tagProperties['title'] = $number + 1;
        parent::__construct($this->occupied ? $this->getOrderQRCode($this->order) : $this->getChairImage($this->chairImage), $alt, $tagProperties);
        $this->addItem(new Label('info', $number));
    }

    public function getOrderQRCode($orderId) {
        return (new QRCode())->render('order:' . $orderId);
    }

    public function getChairImage() {
        return DIR_WS_CATALOG . '/images/' . $this->chairImage;
    }

}
