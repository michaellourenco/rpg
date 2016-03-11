<?php

class D
{

    protected $_lado;

    public function getLado() {
        return $this->_lado;
    }

    public function setLado($lado) {
        $this->_lado = $lado;
        return $this;
    }


    public function getDado() {
        return $this->_lado = rand(1,$this->_lado);
    }

		


}

