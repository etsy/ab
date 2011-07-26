<?php
/**
 * This is for logging errors, etc. This is how the AB2 framework integrates
 * with the error handling facility of your app.
 */
interface AB2_SystemLogger {
    public function info($msg);

    public function error($msg);
}
