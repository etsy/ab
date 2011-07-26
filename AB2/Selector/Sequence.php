<?php
/**
 * A compound selector that tries each selector from a list, and returns the
 * first non-null selection.
 */
class AB2_Selector_Sequence implements AB2_Selector {
    private $_selectors;

    public function __construct($selectors) {
        $this->_selectors = !is_null($selectors) ? $selectors : array();
    }

    public function select($subjectKey) {
        foreach ($this->_selectors as $s) {
            $v = $s->select($subjectKey);

            if (!is_null($v)) {
                return $v;
            }
        }

        return null;
    }
}
