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
        $environmentVariable = new \Smalot\Commander\EnvironmentVariable('VERSION', '1.0');
        $this->assert->string($environmentVariable->getName())->isEqualTo('VERSION');

        $this->assert->exception(
          function () {
              new \Smalot\Commander\EnvironmentVariable('VERS ION', '1.0');
          }
        )->isInstanceOf('\InvalidArgumentException')->hasMessage('Invalid environment variable name.');
        
    }

    public function testString()
    {
        $environmentVariable = new \Smalot\Commander\EnvironmentVariable('VERSION', '1.0');
        $this->assert->string((string)$environmentVariable)->isEqualTo('1.0');

        $environmentVariable = new \Smalot\Commander\EnvironmentVariable('HOME', '$PATH');
        $this->assert->string((string)$environmentVariable)->isEqualTo('$PATH');
    }
}
