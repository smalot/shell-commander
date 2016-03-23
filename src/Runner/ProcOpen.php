<?php

namespace Smalot\Commander\Runner;

use Smalot\Commander\Command;

/**
 * Class ProcOpen
 *
 * cf: https://github.com/phpbrew/phpbrew/blob/master/src/PhpBrew/Process.php
 *
 * @package Smalot\Commander\Runner
 */
class ProcOpen extends RunnerBase
{
    /**
     * @var int
     */
    protected $returnCode;

    /**
     * @var string
     */
    protected $stdout;

    /**
     * @var string
     */
    protected $stderr;

    /**
     * @var double
     */
    protected $duration;

    /**
     * ProcOpen constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param \Smalot\Commander\Command $command
     * @param int $timeout
     * @return string
     * @throws \RuntimeException
     */
    public function run(Command $command, $timeout = 30)
    {
        // Reset previous values.
        $this->duration = $this->returnCode = $this->stdout = $this->stderr = null;

        $process = new Process((string) $command, null, $this->getEnvironmentVariables(), null, $timeout);
        $start = microtime(true);
        $process->run();

        $this->duration = microtime(true) - $start;
        $this->returnCode = $process->getExitCode();
        $this->stdout = $process->getOutput();
        $this->stderr = $process->getErrorOutput();

        if ($this->returnCode) {
            throw new \RuntimeException($this->stderr, $this->returnCode);
        }

        return $this->stdout;
    }

    /**
     * @return float
     */
    public function getDuration() {
        return $this->duration;
    }

    /**
     * @return int
     */
    public function getReturnCode() {
        return $this->returnCode;
    }

    /**
     * @return string
     */
    public function getOutput() {
        return $this->stdout;
    }

    /**
     * @return string
     */
    public function getError() {
        return $this->stderr;
    }
}
