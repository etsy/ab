<?php
/**
 * Interface for classes that implement A/B logging.
 *
 *
 */
interface AB2_Logger {
    /**
     * Log a selection event. This is called by Test.select() when a non-null
     * selection has been made.
     *
     * @param string $testKey
     * @param string $variantKey
     * @param mixed $subjectKey
     */
    public function log($testKey, $variantKey, $subjectKey);
}