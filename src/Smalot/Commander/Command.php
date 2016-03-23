<?php

namespace Smalot\Commander;

/**
 * Class Command
 * @package Smalot\Commander
 */
class Command
{
    /**
     * @var string
     */
    protected $command;

    /**
     * @var array
     */
    protected $subCommands = [];

    /**
     * @var array
     */
    protected $environments = [];

    /**
     * @var array
     */
    protected $arguments = [];

    /**
     * @var array
     */
    protected $params = [];

    /**
     * Command constructor.
     * @param string $command
     */
    public function __construct($command)
    {
        $this->command = $command;
    }

    /**
     * @param string|SubCommand $subCommand
     * @return $this
     */
    public function addSubCommand($subCommand)
    {
        if (!$subCommand instanceof SubCommand) {
            $subCommand = new SubCommand($subCommand);
        }

        $this->subCommands[] = $subCommand;

        return $this;
    }

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
     * @return array
     */
    public function getEnvironmentVariables()
    {
        return $this->environments;
    }

    /**
     * @param string|Argument $argument
     * @param string|null $value
     * @return $this
     */
    public function addArgument($argument, $value = null)
    {
        if (!$argument instanceof Argument) {
            $argument = new Argument($argument, $value);
        }

        $this->arguments[] = $argument;

        return $this;
    }

    /**
     * @param string|Flag $flag
     * @param string|null $value
     * @return $this
     */
    public function addFlag($flag, $value = null)
    {
        if (!$flag instanceof Flag) {
            $flag = new Flag($flag, $value);
        }

        $this->arguments[] = $flag;

        return $this;
    }

    /**
     * @param string|Param $param
     * @return $this
     */
    public function addParam($param)
    {
        if (!$param instanceof Param) {
            $param = new Param($param);
        }

        $this->params[] = $param;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $command = escapeshellarg($this->command) . ' ';

        if ($this->subCommands) {
            $command .= implode(' ', $this->subCommands) . ' ';
        }

        if ($this->arguments) {
            $command .= implode(' ', $this->arguments) . ' ';
        }

        if ($this->params) {
            $command .= implode(' ', $this->params) . ' ';
        }

        return trim($command);
    }
}
