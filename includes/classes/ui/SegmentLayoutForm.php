<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PureOSC\ui;

/**
 * Description of SegmentLayoutForm
 *
 * @author vitex
 */
class SegmentLayoutForm extends \Ease\TWB4\Form {

    private $rows;
    private $columns;
    private $name;
    private $code;

    public function __construct($formProperties = [], $formDivProperties = [], $formContents = null) {
        parent::__construct($formProperties, $formDivProperties, $formContents);
        $this->name = \Ease\WebPage::getRequestValue('segment_name') ? \Ease\WebPage::getRequestValue('segment_name') : '';
        $this->rows = \Ease\WebPage::getRequestValue('segment_rows', 'int') ? \Ease\WebPage::getRequestValue('segment_rows', 'int') : 10;
        $this->columns = \Ease\WebPage::getRequestValue('row_chairs', 'int') ? \Ease\WebPage::getRequestValue('row_chairs', 'int') : 10;
        $this->code = $this->segmentCode();
        $this->addInput(new \Ease\Html\InputTextTag('segment_name', \Ease\WebPage::getRequestValue('segment_name') ? \Ease\WebPage::getRequestValue('segment_name') : '', ['id' => 'segname']), 'Segment name');
        $this->addInput(new \Ease\Html\InputNumberTag('segment_rows', $this->rows, ['id' => 'segrows', 'min' => '1']), 'How many rows in segment ?');
        $this->addInput(new \Ease\Html\InputNumberTag('row_chairs', $this->columns, ['id' => 'rowchairs', 'min' => '1']), 'How many chairs put into row?');
        $this->addItem(new \Ease\Html\InputHiddenTag('segment_code', $this->code, ['id' => 'segmentcode']));
        $this->addItem(new Segment('New', $this->rows, $this->columns));
        $this->addItem(new \Ease\TWB4\SubmitButton('Modify', 'warning',['id'=>'updater']));
        $this->addItem(new \Ease\TWB4\LinkButton('hall.php?add_segment='.$this->code, 'Use',  'success',['id'=>'usenow']));
    }

    public function segmentCode() {
        return Segment::code($this->name, $this->rows, $this->columns);
    }

    public function useCode($code) {
        list($this->name, $this->rows, $this->columns) = Segment::uncode($code);
    }

}
