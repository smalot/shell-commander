<?php

namespace Smalot\Commander;

/**
 * Class Value
 * @package Smalot\Commander
 */
abstract class Value
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $values;

    /**
     * Value constructor.
     * @param string $name
     * @param array|null $values
     */
    public function __construct($name, $values = null)
    {
        $this->name = $name;

        if (!is_array($values) && $values !== null) {
            $values = [$values];
        }

        $this->values = $values;
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
    protected function getValuesAsString()
    {
        $values = array_map('escapeshellarg', $this->values);
        $prefix = sprintf('%s%s=', static::PREFIX, $this->name);

        return $prefix . join(" ${prefix}", $values);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->values === null) {
            return sprintf('%s%s', static::PREFIX, $this->name);
        }

        return $this->getValuesAsString();
    }
}
