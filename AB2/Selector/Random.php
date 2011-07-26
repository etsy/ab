<?php
class AB2_Selector_Random implements AB2_Selector_Randomizer {

    private $_randMax;

    public function __construct() {
        $this->_randMax = min((1 << 31) - 1, mt_getrandmax());
    }

    public function randomize($subjectID) {
        $w = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
        return $w;
    }
}
