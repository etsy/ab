<?php
/**
 * A logging filter that ignores duplicate calls.
 */
class Etsy_AB2_Logger_UniqueEntries implements Etsy_AB2_Logger {
    private $_log;
    private $_logger;

    public function __construct($logger) {
        $this->_log    = array();
        $this->_logger = $logger;
    }

    public function log($testKey, $variantKey, $subjectKey) {
        $logParams = "$testKey:$variantKey:$subjectKey";

        if (!isset($this->_log[$logParams])) {
            $this->_logger->log($testKey, $variantKey, $subjectKey);
            $this->_log[$logParams] = true;
        }
    }

    public function __toString() {
        return __CLASS__ . "[$this->_logger]";
    }
}
