<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PureOSC;

/**
 * Description of Hall
 *
 * @author vitex
 */
class Hall extends Engine {

    public $myTable = 'halls';
    public $nameColumn = 'name';

    public function getHalls() {
        $all = [];
        foreach ($this->getAll() as $hall) {

            $all[$hall['id']]['id'] = $hall['id'];
            $all[$hall['id']]['name'] = $hall['name'];
            $all[$hall['id']]['capacity'] = intval($hall['capacity']);
            $all[$hall['id']]['segments'] = $hall['segments'];
        }
        return $all;
    }

    public function loadFromSQL($itemId) {
        $result = parent::loadFromSQL($itemId);
        $this->setDataValue('segments', json_decode($this->getDataValue('segments'), true));
        return $result;
    }

    public function insertToSQL($data = null) {
        $data['segments'] = json_encode($data['segments']);
        return parent::insertToSQL($data);
    }

    public function updateToSQL($data = null) {
        if (is_null($data)) {
            $data = $this->getData();
        }
        if(array_key_exists('segments', $data)){
            $data['segments'] = json_encode($data['segments']);
        }
        return parent::updateToSQL($data);
    }

    public function getSegments() {
        return empty($this->getDataValue('segments')) ? [] : $this->getDataValue('segments');
    }

    public function addSegment($segmentCode) {
        $segments = $this->getSegments();
        $segmentData = ui\Segment::uncode($segmentCode);
        $segments[$segmentData['name']] = [$segmentData['rows'] => $segmentData['cols']];
        $this->setDataValue('segments', $segments);
        return $this->saveToSQL();
    }
    
    public function delSegment($name) {
        $segments = $this->getSegments();
        unset($segments[$name]);
        $this->setDataValue('segments', $segments);
        return $this->saveToSQL();
    }
    
     public function getAll() {
         $halls = [];
         foreach ($this->listingQuery()->fetchAll() as $hall){
             $hall['segments'] = empty($hall['segments']) ? [] : json_decode($hall['segments'],true);
             $halls[$hall['id']] = $hall;
         }
        return $halls;
    }

}
