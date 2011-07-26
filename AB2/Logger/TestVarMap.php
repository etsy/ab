<?php
/**
 * Logger that maintains a test name -> variant name map of test selections.
 * Subject IDs are ignored. If a given (test, variant) pair is logged multiple
 * times with different subject IDs, the values of the last call will be returned
 * by getMap().
 */
class AB2_Logger_TestVarMap implements AB2_Logger {
    /** @var array test name -> variant name map */
    private $_testVarMap;

    public function __construct() {
        $this->_testVarMap = array();
    }

    public function log($testKey, $variantKey, $subjectKey) {
        $this->_testVarMap[$testKey] = $variantKey;
    }

    /**
     * Clear the map.
     *
     * @return void
     */
    public function clear() {
        $this->_testVarMap = array();
    }

    /**
     * @return array a test name to variant name map. May be empty, but never null.
     */
    public function getMap() {
        return $this->_testVarMap;
    }
}
