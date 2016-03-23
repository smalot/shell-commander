<?php

namespace Smalot\Commander;

/**
 * Class SubCommand
 * @package Smalot\Commander
 */
class SubCommand
{
    /**
     * @var string
     */
    protected $command;

    /**
     * SubCommand constructor.
     * @param string $command
     */
    public function __construct($command)
    {
        $this->command = $command;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return escapeshellarg($this->command);
    }
}
