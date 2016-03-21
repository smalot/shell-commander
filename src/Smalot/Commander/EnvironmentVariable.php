<?php

namespace Smalot\Commander;

/**
 * Class EnvironmentVariable
 * @package Smalot\Commander
 */
class EnvironmentVariable extends Value
{
    /**
     * EnvironmentVariable constructor.
     * @param string $name
     * @param array|null $values
     */
    public function __construct($name, $values = null)
    {
        if (is_array($values) && count($values) > 1) {
            throw new \InvalidArgumentException('Array is not supported.');
        }

        parent::__construct($name, $values);
    }

    /**
     * @return string
     */
    protected function getValuesAsString()
    {
        $value = reset($this->values);

        if (!preg_match('/^(`.*`)$/', $value)) {
            $value = escapeshellarg($value);
        }

        return $this->name . '=' . $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->values === null || count($this->values) === 0) {
            return '';
        }

        return $this->getValuesAsString();
    }
}
