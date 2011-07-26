<?php
interface Etsy_AB2_Selector {
    /**
     * selects a variant.
     *
     * @param  string $subjectID
     * @return variant key (name)
     */
    public function select($subjectID);
}
