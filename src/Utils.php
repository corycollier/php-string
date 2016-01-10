<?php
/**
 * Util Class
 *
 * @category    PHP
 * @package     WpWodify
 * @subpackage  Util
 * @since       File available since release 1.0.x
 * @author      Cory Collier <corycollier@corycollier.com>
 */

namespace PhpString;

/**
 * Util Class
 *
 * @category    PHP
 * @package     WpWodify
 * @subpackage  Util
 * @since       Class available since release 1.0.x
 * @author      Cory Collier <corycollier@corycollier.com>
 */
class Utils
{
    const ERR_ARG_MUST_BE_STRING = 'The first argument to the constructor of Utils must be a string';

    /**
     * Internal placeholder for the string value.
     *
     * @var string
     */
    protected $string;

    /**
     * Internal placeholder for the ORIGINAL string value.
     *
     * @var string
     */
    protected $original;

    /**
     * Array of string values that will be used to separate strings.
     *
     * @var array
     */
    protected $separators = [];

    /**
     * Constructor value.
     *
     * @param string $string The string to use for modifications.
     *
     * @param array $separators An array of separating values.
     */
    public function __construct($string = '', $separators = null)
    {
        if (! is_string($string)) {
            throw new Exception(self::ERR_ARG_MUST_BE_STRING);
        }
        $defaults         = [' '];
        $this->string     = $string;
        $this->original   = $string;
        $this->separators = $separators ? $separators : $defaults;
    }

    /**
     * Sets the internal string value to a human readable value.
     *
     * @return PhpString\Utils Returns $this, for object-chaining.
     */
    public function humanify()
    {
        $replacements = $this->buildAssociativeArrayOfSeparators(' ');
        $this->string = trim(strtr($this->string, $replacements));
        return $this;
    }

    /**
     * Sets the internal string value to a machine readable value.
     *
     * @return PhpString\Utils Returns $this, for object-chaining.
     */
    public function machinify()
    {
        $this->dashify()->lowercasify();
        return $this;
    }

    /**
     * Sets the internal string value to a dash-separated string.
     *
     * @return PhpString\Utils Returns $this, for object-chaining.
     */
    public function dashify()
    {
        $replacements = $this->buildAssociativeArrayOfSeparators('-');
        $this->string = strtr($this->string, $replacements);
        return $this;
    }

    /**
     * Sets the internal string value to an underscore-separated string.
     *
     * @return PhpString\Utils Returns $this, for object-chaining.
     */
    public function underscorify()
    {
        $replacements = $this->buildAssociativeArrayOfSeparators('_');
        $this->string = strtr($this->string, $replacements);
        return $this;
    }

    /**
     * Sets the internal string value to lowercase.
     *
     * @return PhpString\Utils Returns $this, for object-chaining.
     */
    public function lowercasify()
    {
        $this->string = strtolower($this->string);
        return $this;
    }

    /**
     * Sets the internal string value to uppercase.
     *
     * @return PhpString\Utils Returns $this, for object-chaining.
     */
    public function uppercasify()
    {
        $this->string = strtoupper($this->string);
        return $this;
    }

    /**
     * Sets the internal string value to a propercased string.
     *
     * @return PhpString\Utils Returns $this, for object-chaining.
     */
    public function propercasify()
    {
        foreach ($this->separators as $separator) {
            $parts = explode($separator, $this->string);
            foreach ($parts as $i => $part) {
                $parts[$i] = ucwords($part);
            }
            $this->string = implode($separator, $parts);
        }

        return $this;
    }

    /**
     * Creates an associative array of replacements.
     *
     * @param string $value The value for replacements.
     *
     * @return array An associative array of replacements.
     */
    protected function buildAssociativeArrayOfSeparators($value)
    {
        $length = count($this->separators);
        $values = array_fill(0, $length, $value);
        $result = array_combine($this->separators, $values);
        return $result;
    }

    /**
     * Getter for the internal string value
     *
     * @return string The strinv value.
     */
    public function getString()
    {
        return $this->string;
    }
}