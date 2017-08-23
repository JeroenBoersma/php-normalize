<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 23-8-17
 * Time: 9:22
 */

namespace Rule;

use Srcoder\Normalize\Rule\Append;
use PHPUnit\Framework\TestCase;

class AppendTest extends TestCase
{

    protected $rule;

    public function setUp()
    {
        $this->rule = new Append(' World!');
    }

    public function testShouldBeAppended()
    {
        $this->assertSame('Hello World!', $this->rule->apply('Hello'));
        $this->assertNotSame('Hello World!', $this->rule->apply('Nope'));
    }

}
