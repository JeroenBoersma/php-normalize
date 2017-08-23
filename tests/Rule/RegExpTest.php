<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 23-8-17
 * Time: 10:08
 */

namespace Rule;

use Srcoder\Normalize\Rule\RegExp;
use PHPUnit\Framework\TestCase;

class RegExpTest extends TestCase
{

    protected $rule;

    public function setUp()
    {
        $this->rule = new RegExp('#[A-Z!]+#', '+');
    }

    public function testShouldRegExp()
    {
        $this->assertSame('+ello +orld+', $this->rule->apply('Hello World!'));
        $this->assertNotSame('Hello World!', $this->rule->apply('Hello World!'));
    }

}
