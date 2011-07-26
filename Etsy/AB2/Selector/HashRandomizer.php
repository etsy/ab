<?php
/**
 * This randomizer hashes a (subject ID, test key) pair.
 */
class Etsy_AB2_Selector_HashRandomizer implements Etsy_AB2_Selector_Randomizer {
    private $_algo = 'sha256';
    private $_testKey;
    private $_testKeyHash;

    /**
     * @param string $testKey
     * @return void
     */
    public function __construct($testKey) {
        $this->_testKey = $testKey;
    }

    /**
     * Map a subject (user) ID to a value in the half-open interval [0, 1).
     *
     * @param  $subjectID
     * @return float
     */
    public function randomize($subjectID) {
        return !is_null($subjectID) ? $this->hash1($subjectID) : 0;
    }

    private function hash1($subjectID) {
        $h = hash($this->_algo, "$this->_testKey-$subjectID");

        return $this->mapHex($h);
    }

    private function hash2($subjectID) {
        $h = hash($this->_algo, "$this->_testKey-$subjectID");
        $h = hash($this->_algo, $h);
        $w = $this->mapHex($h);

        return $w;
    }

    private function hash3($subjectID) {
        if (is_null($this->_testKeyHash)) {
            $this->_testKeyHash = substr(
              hash($this->_algo, $this->_testKey), 0, 24
            );
        }

        $h = hash($this->_algo, "$this->_testKeyHash-$subjectID");
        $h = hash($this->_algo, $h);
        $w = $this->mapHex($h);

        return $w;
    }

    /**
     * Map a hex value to the half-open interval [0, 1) while
     * preserving uniformity of the input distribution.
     *
     * @param string $hex a hex string
     * @return float
     */
    private function mapHex($hex) {
        $len  = min(40, strlen($hex));
        $vMax = 1 << $len;
        $v    = 0;

        for ($i = 0; $i < $len; $i++) {
            $bit = hexdec($hex[$i]) < 8 ? 0 : 1;
            $v = ($v << 1) + $bit;
        }

        $w = $v / $vMax;

        return $w;
    }
}
