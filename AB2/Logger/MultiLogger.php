<?php
require_once "AB2/Logger.php";

/**
 * Logger that passes calls through to multiple loggers.
 *
 */
class AB2_Logger_MultiLogger implements AB2_Logger {

    private $loggers;
    
    public function __construct($loggers) {
        if (!is_array($loggers)) {
            throw new InvalidArgumentException('we need an array of loggers here');
        }
        $this->loggers = $loggers;
    }

    public function log($testKey, $variantKey, $subjectKey) {
        foreach ($this->loggers as $logger) {
            try {
                $logger->log($testKey, $variantKey, $subjectKey);
            } catch (Exception $err) {
                // if one logger fails, log the error and go on to the next one
                Logger::log_error("AB Logger failed: $err", 'AB');
            }
        }
    }
}
