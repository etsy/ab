<?php
/**
 * Logger that passes calls through to multiple loggers. This is a best-effort 
 * implementation: if a logger throws an exception during the log() call, 
 * the multilogger will log the error and move on to the next logger, if any.
 *
 */
class AB2_Logger_MultiLogger implements AB2_Logger {

    private $_loggers;
    private $_sysLogger;

    public function __construct($loggers, $sysLogger) {
        if (!is_array($loggers)) {
            throw new InvalidArgumentException('we need an array of loggers here');
        }
        if (is_null($sysLogger)) {
            throw new InvalidArgumentException('we need a systen logger to report possible errors.'); 
        }
        $this->_loggers = $loggers;
        $this->_sysLogger = $sysLogger;
    }

    public function log($testKey, $variantKey, $subjectKey) {
        foreach ($this->_loggers as $logger) {
            try {
                $logger->log($testKey, $variantKey, $subjectKey);
            } catch (Exception $err) {
                $this->_sysLogger->error("AB2_Logger failed: $err");
            }
        }
    }
}
