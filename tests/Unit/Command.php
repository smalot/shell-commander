<?php

namespace Smalot\Commander\Tests\Unit;

use mageekguy\atoum;

/**
 * Class Command
 *
 * @package Smalot\Commander\Tests\Unit
 */
class Command extends atoum\test
{
    public function testString()
    {
        $command = new \Smalot\Commander\Command('/usr/folder with space/apt');
        $command->addParam('param1');
        $command->addFlag('v');
        $command->addParam('param2');
        $this->assert->string((string)$command)->isEqualTo("'/usr/folder with space/apt' -v 'param1' 'param2'");

        $command = new \Smalot\Commander\Command('git');
        $command->addSubCommand('commit');
        $command->addFlag('m', 'message for commit');
        $this->assert->string((string)$command)->isEqualTo("'git' 'commit' -m 'message for commit'");

        $command = new \Smalot\Commander\Command('git');
        $command->addSubCommand('commit');
        $command->addFlag('m', 'message for commit');
        $this->assert->string((string)$command)->isEqualTo("'git' 'commit' -m 'message for commit'");

        $command = new \Smalot\Commander\Command('git');
        $command->addEnvironmentVariable('CURRENT', '`pwd`');
        $command->addEnvironmentVariable('HOME', '/home/username');
        $command->addSubCommand('commit');
        $command->addArgument('interactive');
        $command->addFlag('m', 'message for commit');
        $this->assert->string((string)$command)->isEqualTo("'git' 'commit' --interactive -m 'message for commit'");
    }
}
