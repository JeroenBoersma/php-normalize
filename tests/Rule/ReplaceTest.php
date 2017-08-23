<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 23-8-17
 * Time: 10:11
 */

namespace Rule;

use Srcoder\Normalize\Rule\Replace;
use PHPUnit\Framework\TestCase;

class ReplaceTest extends TestCase
{

    protected $rule;

    public function setUp()
    {
        $this->rule = new Replace('o', '+');
    }

    public function testShouldReplace()
    {
        $this->assertSame('Hell+ W+rld!', $this->rule->apply('Hello World!'));
        $this->assertNotSame('Hello World!', $this->rule->apply('Hello World!'));
    }

}
