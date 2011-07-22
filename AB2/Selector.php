<?php

interface AB2_Selector {
    /**
     * selects a variant.
     *
     * @param string $subjectID
     * @return variant key (name)
     */
    public function select($subjectID);
}