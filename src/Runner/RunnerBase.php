<?php

namespace Smalot\Commander\Runner;

use Smalot\Commander\Command;
use Smalot\Commander\EnvironmentVariable;

/**
 * Class RunnerBase
 * @package Smalot\Commander\Runner
 */
abstract class RunnerBase
{
    /**
     * @var array
     */
    protected $environments = [];

    /**
     * @param string|EnvironmentVariable $environment
     * @param string|null $value
     * @return $this
     */
    public function addEnvironmentVariable($environment, $value = null)
    {
        if (!$environment instanceof EnvironmentVariable) {
            $environment = new EnvironmentVariable($environment, $value);
        }

        $this->environments[$environment->getName()] = $environment->getValue();

        return $this;
    }

    /**
     * @param array $environments
     * @return $this
     */
    public function addEnvironmentVariables($environments)
    {
        foreach ($environments as $environment => $value) {
            if ($value instanceof EnvironmentVariable) {
                $this->addEnvironmentVariable($value);
            } else {
                $this->addEnvironmentVariable($environment, $value);
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getEnvironmentVariables()
    {
        return $this->environments;
    }

    /**
     * @param \Smalot\Commander\Command $command
     * @param int $timeout
     * @return string
     */
    abstract public function run(Command $command, $timeout = -1);

    /**
     * @return float
     */
    abstract public function getDuration();

    /**
     * @return int
     */
    abstract public function getReturnCode();

    /**
     * @return string
     */
    abstract public function getOutput();

    /**
     * @return string
     */
    abstract public function getError();
}
