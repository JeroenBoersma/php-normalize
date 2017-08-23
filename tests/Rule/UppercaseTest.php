<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 23-8-17
 * Time: 10:14
 */

namespace Rule;

use Srcoder\Normalize\Rule\Uppercase;
use PHPUnit\Framework\TestCase;

class UppercaseTest extends TestCase
{

    protected $rule;

    public function setUp()
    {
        $this->rule = new Uppercase;
    }

    public function testShouldBeUppercase()
    {
        $this->assertSame('HELLO WORLD!', $this->rule->apply('Hello World!'));
        $this->assertNotSame('Hello World!', $this->rule->apply('Hello World!'));
    }

}
