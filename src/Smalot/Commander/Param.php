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
        return escapeshellarg($this->value);
    }
}
