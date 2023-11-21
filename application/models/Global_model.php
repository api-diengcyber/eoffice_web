<?php
class Global_model extends CI_Model {
    private $globalVariable = 'Nilai Variabel Global';

    public function getGlobalVariable() {
        return $this->globalVariable;
    }

    public function setGlobalVariable($newValue) {
        $this->globalVariable = $newValue;
    }
}