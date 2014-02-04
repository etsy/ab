<?php
/**
 * A SubjectIDProvider is used by some selectors to obtain a subject ID
 * when one isn't passed to the selector explicitly. E.g., a provider
 * may read the ID from a cookie.
 */
interface Etsy_AB2_SubjectIDProvider {
    /**
     * @abstract
     * @return string
     */
    public function getID();
}
