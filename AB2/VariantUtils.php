<?php

class AB2_VariantUtils {
    /**
     * Create an array of variants with names from a weight array and optionally,
     * properties from an k-v array.
     *
     * @static
     * @param array $weights an associative array mapping variant names to weights
     * @param array $props an associative array mapping variant names to properties
     * @return array
     */
    public static function buildVariants($weights, $props) {
        if (!is_array($weights)) {
            throw new InvalidArgumentException('We need an associative array of weights here.');
        }
        $props = is_null($props) ? array() : $props;
        $variants = array();
        foreach (array_keys($weights) as $vk) {
            $variants[] = new AB2_Variant($vk, isset($props[$vk]) ? $props[$vk] : null);
        }
        return $variants;
    }


    /**
     * Set all variants to the same weight for ease of analysis. Create extra
     * 'overflow' variants as needed to maintain the original ratios of treatment
     * group sizes.
     *
     * @return array new weights
     */
    public static function equalizeWeights($weights) {
        if (is_null($weights)) {
            return null;
        }

        // determine minimum non-zero weight
        $base = null;
        foreach ($weights as $w) {
            if ($w > 0) {
                $base = is_null($base) ? $w : min($w, $base);
            }
        }

        if ($base) {
            // first make a copy
            $newWeights = array();
            foreach ($weights as $vk => $w) {
                $newWeights[$vk] = $w;
            }
            // now split entries in the new copy as needed
            // iterate through the old array but modify the new one
            foreach ($weights as $vk => $w) {
                if ($w > $base) {
                    $vk2 = self::newKey($newWeights, $vk);
                    if ($vk2) {
                        $newWeights[$vk] = $base;
                        $newWeights[$vk2] = $w - $base;
                    }
                }
            }
            return $newWeights;
        }

        return $weights;
    }

    /**
     * Find a new key based on a given key. Keep appending '_'s to the original
     * key until a new unique key is found or 5 '_'s have been appended.
     *
     * @static
     * @param  $a
     * @param  $k
     * @return string a new unique key or null if all the new key candidates already
     * exist in the array.
     */
    private static function newKey($a, $k) {
        $newk = $k;
        for ($i = 0; $i < 5; $i++) {
            $newk .= '_';
            if (!array_key_exists($newk, $a)) {
                return $newk;
            }
        }
        return null;
    }

}
