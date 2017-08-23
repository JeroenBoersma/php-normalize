<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 23-8-17
 * Time: 10:04
 */

namespace Rule;

use Srcoder\Normalize\Rule\Lowercase;
use PHPUnit\Framework\TestCase;

class LowercaseTest extends TestCase
{

    protected $rule;

    public function setUp()
    {
        $this->rule = new Lowercase(' World!');
    }

    public function testShouldBeLowercase()
    {
        $this->assertSame('hello world!', $this->rule->apply('Hello World!'));
        $this->assertNotSame('Hello World!', $this->rule->apply('Hello World!'));
    }

}
