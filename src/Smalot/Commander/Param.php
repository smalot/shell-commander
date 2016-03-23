<?php

namespace Smalot\Commander;

/**
 * Class Param
 * @package Smalot\Commander
 */
class Param
{
    /**
     * @var string
     */
    protected $value;

    /**
     * Param constructor.
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (preg_match('/^(\$[A-Z0-9]+)$/i', $this->value)) {
            return $this->value;
        } else {
            return escapeshellarg($this->value);
        }
    }
}
