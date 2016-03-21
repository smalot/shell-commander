<?php

namespace Smalot\Commander\Tests\Unit;

use mageekguy\atoum;

/**
 * Class Param
 *
 * @package Smalot\Commander\Tests\Unit
 */
class Param extends atoum\test
{
    public function testValue()
    {
        $param = new \Smalot\Commander\Param('version');
        $this->assert->string($param->getValue())->isEqualTo('version');
    }

    public function testString()
    {
        $param = new \Smalot\Commander\Param('version');
        $this->assert->string((string) $param)->isEqualTo("'version'");

        $param = new \Smalot\Commander\Param('ver sion');
        $this->assert->string((string) $param)->isEqualTo("'ver sion'");

        $param = new \Smalot\Commander\Param("a'b");
        $this->assert->string((string) $param)->isEqualTo("'a'\''b'");
        $this->assert->string((string) $param)->isEqualTo(escapeshellarg("a'b"));

        $param = new \Smalot\Commander\Param('ver;sion');
        $this->assert->string((string) $param)->isEqualTo("'ver;sion'");
    }
}
