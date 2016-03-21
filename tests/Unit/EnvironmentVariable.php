<?php

namespace Smalot\Commander\Tests\Unit;

use mageekguy\atoum;

/**
 * Class EnvironmentVariable
 *
 * @package Smalot\Commander\Tests\Unit
 */
class EnvironmentVariable extends atoum\test
{
    public function testName()
    {
        $environmentVariable = new \Smalot\Commander\EnvironmentVariable('VERSION');
        $this->assert->string($environmentVariable->getName())->isEqualTo('VERSION');
    }

    public function testString()
    {
        $environmentVariable = new \Smalot\Commander\EnvironmentVariable('VERSION');
        $this->assert->string((string)$environmentVariable)->isEqualTo('');

        $environmentVariable = new \Smalot\Commander\EnvironmentVariable('VERSION', '1.5');
        $this->assert->string((string)$environmentVariable)->isEqualTo("VERSION='1.5'");

        $environmentVariable = new \Smalot\Commander\EnvironmentVariable('VERSION', '');
        $this->assert->string((string)$environmentVariable)->isEqualTo("VERSION=''");

        $environmentVariable = new \Smalot\Commander\EnvironmentVariable('VERSION', "a'b");
        $this->assert->string((string)$environmentVariable)->isEqualTo("VERSION='a'\''b'");
        $this->assert->string((string)$environmentVariable)->isEqualTo('VERSION='.escapeshellarg("a'b")); // Really ?

        $this->assert->exception(
          function () {
              $environmentVariable = new \Smalot\Commander\EnvironmentVariable('VERSION', [1.5, 1.8]);
          }
        )->isInstanceOf("\InvalidArgumentException")->hasMessage('Array is not supported.');
    }
}
