<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 23-8-17
 * Time: 9:42
 */

use Srcoder\Normalize\Rule\Callback;
use PHPUnit\Framework\TestCase;

class CallbackTest extends TestCase
{

    protected $rule;

    public function setUp()
    {
        $mock = $this->getMockBuilder('stdClass')
                ->setMethods(['callback'])
                ->getMock();

        $mock->expects($this->once())
                ->method('callback')
                ->with($this->equalTo('Hello'))
                ->will($this->returnValue(true));

        $callback = function(string $string) use ($mock) {
            $this->assertSame(true, $mock->callback($string));
            return 'Hello World!';
        };

        $this->rule = new Callback($callback);
    }

    public function testShouldDoCallback()
    {
        $this->assertSame('Hello World!', $this->rule->apply('Hello'));
    }

}
