<?php

namespace Smalot\Commander\Tests\Unit\Runner;

use mageekguy\atoum;

/**
 * Class ProcOpen
 *
 * @package Smalot\Commander\Tests\Unit\Runner
 */
class ProcOpen extends atoum\test
{
    public function testRun()
    {
        $runner = new \Smalot\Commander\Runner\ProcOpen();

        // Commande OK !
        $command = new \Smalot\Commander\Command('ls');
        $command->addFlag('a');
        $command->addFlag('l');
        $command->addParam('/tmp');

        $runner->run($command, 1);

        $this->assert->integer($runner->getReturnCode())->isEqualTo(0);
        $this->assert->float($runner->getDuration())->isGreaterThan(0);
        $this->assert->float($runner->getDuration())->isLessThan(2);
        $this->assert->string($runner->getOutput())->contains('total');
        $this->assert->string($runner->getError())->isEqualTo('');

        // Timeout !
        $command = new \Smalot\Commander\Command('sleep');
        $command->addParam('10');
        $this->assert->exception(function() use ($runner, $command) {
            $runner->run($command, 1);
        })->isInstanceOf('\Smalot\Commander\Runner\TimeoutException');

        // Unknown command line.
        $command = new \Smalot\Commander\Command('foobar');
        $command->addParam('-v');
        $runner->run($command, 1);

        $this->assert->integer($runner->getReturnCode())->isEqualTo(127);
        $this->assert->float($runner->getDuration())->isLessThan(1);
        $this->assert->string($runner->getOutput())->isEqualTo('');
        $this->assert->string($runner->getError())->contains('foobar')->contains('not found');
    }
}
