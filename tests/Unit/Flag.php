<?php

namespace Smalot\Commander\Tests\Unit;

use mageekguy\atoum;

/**
 * Class Flag
 *
 * @package Smalot\Commander\Tests\Unit
 */
class Flag extends atoum\test
{
    public function testName()
    {
        $flag = new \Smalot\Commander\Flag('v');
        $this->assert->string($flag->getName())->isEqualTo('v');
    }

    public function testString()
    {
        $flag = new \Smalot\Commander\Flag('v');
        $this->assert->string((string) $flag)->isEqualTo('-v');

        $argument = new \Smalot\Commander\Flag('v', '1.5');
        $this->assert->string((string) $argument)->isEqualTo("-v '1.5'");

        $argument = new \Smalot\Commander\Flag('v', "a'b");
        $this->assert->string((string) $argument)->isEqualTo("-v 'a'\''b'");
        $this->assert->string((string) $argument)->isEqualTo("-v " . escapeshellarg("a'b"));

        $argument = new \Smalot\Commander\Flag('v', [1.5, 1.8]);
        $this->assert->string((string) $argument)->isEqualTo("-v '1.5' -v '1.8'");
    }
}
