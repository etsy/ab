<?php
/**
 * A variant selector that returns a fixed variant.
 */
class Etsy_AB2_Selector_Fixed implements Etsy_AB2_Selector {
    private $_varName;

    public function __construct($varName) {
        $this->_varName = $varName;
    }

    /**
     * @param  mixed  $subject
     * @return string variant name
     */
    public function select($subject) {
        return $this->_varName;
    }

    public function getVariantName() {
        return $this->_varName;
    }
}
