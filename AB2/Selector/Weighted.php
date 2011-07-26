<?php
/**
 *
 */
class AB2_Selector_Weighted implements AB2_Selector {
    private $_weights;
    private $_sumWeights;
    private $_partitions;

    /**
     * @var AB2_Selector_Randomizer
     */
    private $_randomizer;

    /**
     * @param string $testKey
     * @param array $weights an associative array of variation ID => weights
     * @param AB2_Selector_Randomizer $randomizer
     * @throws Exception_ArgumentException
     */
    public function __construct($weights, $randomizer) {
        if (!is_array($weights)) {
            throw new InvalidArgumentException(
              'weights must be a numerical array'
            );
        }

        if (is_null($randomizer)) {
            throw new InvalidArgumentException(
              'A non-null randomizer is required.'
            );
        }

        // check the weights and build the partition array
        $sum   = 0;
        $parts = array();

        foreach ($weights as $var => $w) {
            if (!(is_numeric($w) && $w >= 0)) {
                throw new InvalidArgumentException("invalid weight: $w");
            }

            // ignore the 0-weighted variations
            if ($w > 0) {
                $sum += floatval($w);
                $parts[strval($sum)] = $var;
            }
        }

        $this->_weights    = $weights;
        $this->_sumWeights = $sum;
        $this->_partitions = $parts;
        $this->_randomizer = $randomizer;
    }

    /**
     * @param mixed $subjectID subject ID used for hashing.
     * @return string variant key or null if no selection could be made
     *          (probably because no subject ID could be determined).
     */
    public final function select($subjectID) {
        if (!empty($this->_partitions)) {
            $r = $this->_randomizer->randomize($subjectID);
            $w = $r * $this->getSumWeights();

            return $this->findPartition($w);
        }

        return null;
    }

    private function getSumWeights() {
        return $this->_sumWeights;
    }

    private function findPartition($w) {
        foreach ($this->_partitions as $max => $var) {
            if ($w < $max) {
                return $var;
            }
        }

        /* return the last partition under the assumption that a round-off error
         * caused $w to exceed the upper bound. */
        return $this->_partitions[$this->_sumWeights];
    }

    public function __toString() {
        $strs = array();

        foreach ($this->_weights as $var => $w) {
            $strs[] = "$var=>$w";
        }

        $weights = join(", ", $strs);

        return "weighted selector: weights=[$weights]";
    }
}
