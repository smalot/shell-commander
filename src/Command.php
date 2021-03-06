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
     * @param array $arguments
     * @return $this
     */
    public function addArguments($arguments)
    {
        foreach ($arguments as $argument => $value) {
            if ($value instanceof Argument) {
                $this->addArgument($value);
            } else {
                $this->addArgument($argument, $value);
            }
        }

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
     * @param array $flags
     * @return $this
     */
    public function addFlags($flags)
    {
        foreach ($flags as $flag => $value) {
            if ($value instanceof Flag) {
                $this->addFlag($value);
            } else {
                $this->addFlag($flag, $value);
            }
        }

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
     * @param array $params
     * @return $this
     */
    public function addParams($params)
    {
        foreach ($params as $param) {
            $this->addParam($param);
        }

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
