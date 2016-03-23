<?php

namespace Smalot\Commander;

/**
 * Class EnvironmentVariable
 * @package Smalot\Commander
 */
class EnvironmentVariable
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;
    
    /**
     * EnvironmentVariable constructor.
     * @param string $name
     * @param string $value
     */
    public function __construct($name, $value)
    {
        if (!preg_match('/^[a-zA-Z_]+[a-zA-Z0-9_]*$/i', $name)) {
            throw new \InvalidArgumentException('Invalid environment variable name.');
        }

        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
        return $this->value;
    }
}
