<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 23-8-17
 * Time: 9:42
 */

use Srcoder\Normalize\Rule\Prepend;
use PHPUnit\Framework\TestCase;

class PrependTest extends TestCase
{

    protected $rule;

    public function setUp()
    {
        $this->rule = new Prepend('Hello ');
    }

    public function testShouldBePrepended()
    {
        $this->assertSame('Hello World!', $this->rule->apply('World!'));
        $this->assertNotSame('Hello World!', $this->rule->apply('Nope'));
    }

}
