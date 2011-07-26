<?php

/**
 * A test variant. Each variant consists of a unique name (within each test) and an optional
 * properties array. Properties are particularly helpful when different variants specify
 * combinations of options, etc.
 *
 */
class AB2_Variant {
    const VALID_NAMES = '/^[a-zA-Z0-9_-]+$/';

    private $_name;
    private $_props;

    /**
     * @param string $name name of the test
     * @param array $props optional property array; null or missing $props is
     * treated as array().
     * @throws InvalidArgumentException
     */
    public function __construct($name, $props=null) {
        $name = strval($name);
        if (!preg_match(self::VALID_NAMES, $name)) {
            throw new InvalidArgumentException("name must be a non-empty string consisting of alphanumeric characters, '-' and '_'.");
        }

        $props = !is_null($props) ? $props : array();
        if (!is_array($props)) {
            throw new InvalidArgumentException("props must be an array.");
        }

        $this->_name = $name;
        $this->_props = $props;
    }

    /**
     * @return string test name
     */
    public function getName() {
        return $this->_name;
    }

    /**
     * @return array properties
     */
    public function getProperties() {
        return $this->_props;
    }

    /**
     * Convenient method for retrieving an individual property.
     *
     * @param  $key
     * @param  $default
     * @return property value under $key if it exists (it could be null); or $default
     * if the key doesn't exist.
     */
    public function getProperty($key, $default=null) {
        return array_key_exists($key, $this->_props) ? $this->_props[$key] : $default;
    }

    function __toString() {
        $props = print_r($this->_props, true);
        return "AB2_Variant[$this->_name, $props]";
    }
}
