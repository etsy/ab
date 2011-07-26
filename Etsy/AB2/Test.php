<?php
/**
 * A test is defined by <ol>
 * <li>a unique name</li>
 * <li>a set of variants that specify different program behavior</li>
 * <li>a <i>selector</i> that picks a variant for each user/subject</li>
 * <li>an <i>ID provider</i> that supplies user/subject IDs when they're not given explicitly by the caller</li>
 * <li>a <li>logger</li> that logs each non-null selection</li>
 * </ol>
 */
class Etsy_AB2_Test {
    const VALID_NAMES = '/^[a-zA-Z0-9._-]+$/';

    /** @var string */
    private $_name;

    /** @var array a LUT for variants by name */
    private $_variantsByName;

    /** @var Etsy_AB2_Selector */
    private $_selector;

    /** @var Etsy_AB2_SubjectIDProvider */
    private $_subjectIDProvider;

    /** @var Etsy_AB2_Logger */
    private $_logger;

    /** @var Etsy_AB2_EntryCondition */
    private $_condition;

    /**
     * @param string $name
     * @param array $variants an array of Etsy_AB2_Variants
     * @param Etsy_AB2_Selector $selector
     * @param Etsy_AB2_SubjectIDProvider $subjectIDProvider
     * @param Etsy_AB2_Logger $logger
     * @param Etsy_AB2_EntryCondition $condition an optional entry condition. If it's
     *        not specified, this tests will always be on.
     * @throws InvalidArgumentException for bad input
     */
    public function __construct($name, $variants, $selector, $subjectIDProvider, $logger, $condition=null) {
        if (!is_string($name) || !preg_match(self::VALID_NAMES, $name)) {
            throw new InvalidArgumentException(
              "name must be a non-empty string consisting of alphanumeric charactesr, '-' and '_'."
            );
        }

        if (!is_array($variants)) {
            throw new InvalidArgumentException("variants must be an array.");
        }

        $this->_name              = $name;
        $this->_selector          = $selector;
        $this->_subjectIDProvider = $subjectIDProvider;
        $this->_logger            = $logger;
        $this->_condition         = $condition;
        $this->_variantsByName    = array();

        foreach ($variants as $v) {
            $this->_variantsByName[$v->getName()] = $v;
        }
    }

    /**
     * @return string
     */
    public final function getName() {
        return $this->_name;
    }

    /**
     * @return array an array of variants, keyed by variant names. never null.
     */
    public final function getVariants() {
        return $this->_variantsByName;
    }

    /**
     * @return Etsy_AB2_Selector
     */
    public final function getSelector() {
        return $this->_selector;
    }

    public final function getLogger() {
        return $this->_logger;
    }

    /**
     * Selects a variant for the given subject (typically a user).
     *
     * @param  $subjectID
     * @return Etsy_AB2_Variant a variant or null if no selection was made.
     */
    public function select($subjectID = null) {
        if ($this->_condition && !$this->_condition->isMet()) {
            return null;
        }

        if (is_null($subjectID) && !is_null($this->_subjectIDProvider)) {
            $subjectID = $this->_subjectIDProvider->getID();
        }

        $varKey = $this->getSelector()->select($subjectID);

        if (!is_null($varKey) && isset($this->_variantsByName[$varKey])) {
            $this->_logger->log($this->_name, $varKey, $subjectID);

            return $this->_variantsByName[$varKey];
        }

        return null;
    }

    /**
     * A convenience method that calls select(), and then return the name
     * of the selected variant's name if one was selected.
     *
     * @param  $subjectID
     * @return string variant name, or null if none was selected
     */
    public function selectName($subjectID = null) {
        $var = $this->select($subjectID);

        return $var ? $var->getName() : null;
    }

    /**
     * A convenience method that calls select(), and then return the properties
     * of the selected variant if one was selected.
     *
     * @param  $subjectID
     * @return mixed properties array, or null if none was selected
     */
    public function selectProperties($subjectID = null) {
        $var = $this->select($subjectID);

        return $var ? $var->getProperties() : null;
    }
}
