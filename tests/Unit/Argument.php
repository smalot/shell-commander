<?php

namespace Smalot\Commander\Tests\Unit;

use mageekguy\atoum;

/**
 * Class Argument
 *
 * @package Smalot\Commander\Tests\Unit
 */
class Argument extends atoum\test
{
    public function testName()
    {
        $argument = new \Smalot\Commander\Argument('version');
        $this->assert->string($argument->getName())->isEqualTo('version');
    }

    public function testString()
    {
        $argument = new \Smalot\Commander\Argument('version');
        $this->assert->string((string) $argument)->isEqualTo('--version');

        $argument = new \Smalot\Commander\Argument('version', '1.5');
        $this->assert->string((string) $argument)->isEqualTo("--version '1.5'");

        $argument = new \Smalot\Commander\Argument('version', "a'b");
        $this->assert->string((string) $argument)->isEqualTo("--version 'a'\''b'");
        $this->assert->string((string) $argument)->isEqualTo("--version " . escapeshellarg("a'b"));

        $argument = new \Smalot\Commander\Argument('version', [1.5, 1.8]);
        $this->assert->string((string) $argument)->isEqualTo("--version '1.5' --version '1.8'");
    }
}
