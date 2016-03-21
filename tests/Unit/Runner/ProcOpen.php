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

//        $command = new \Smalot\Commander\Command('ls');
//        $command->addFlag('a');
//        $command->addFlag('l');
//        $command->addParam('/tmp');
//
//        $runner->run($command, 1000);
//        $this->assert->integer($runner->getReturnCode())->isEqualTo(0);
//        $this->assert->float($runner->getDuration())->isGreaterThan(0);
//        $this->assert->string($runner->getOutput())->contains('total');
//        $this->assert->string($runner->getError())->isEqualTo('');

        $command = new \Smalot\Commander\Command('sleep');
        $command->addParam('10');

        $runner->run($command, 1);
        $this->assert->integer($runner->getReturnCode())->isEqualTo(0);
        $this->assert->float($runner->getDuration())->isLessThan(2);
        $this->assert->string($runner->getOutput())->isEqualTo('');
        $this->assert->string($runner->getError())->isEqualTo('');

        var_dump($runner);
    }
}
