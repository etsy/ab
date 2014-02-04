<?php
interface Etsy_AB2_Selector_Randomizer {
    /**
     * Map a subject (user) ID to a value in the half-open interval [0, 1).
     *
     * @param  $subjectID
     * @return float
     */
    function randomize($subjectID);
}
