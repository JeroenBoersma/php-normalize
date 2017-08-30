<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 23-8-17
 * Time: 10:15
 */

namespace Rule;

use Srcoder\Normalize\Rule\Replace;
use Srcoder\Normalize\Rule\RuleInterface;
use Srcoder\Normalize\Rule\Safe;
use PHPUnit\Framework\TestCase;

class SafeTest extends TestCase
{

    public function testShouldOnlyRunOnce()
    {
        $mock = $this->getMockBuilder(RuleInterface::class)
                ->setMethods(['apply'])
                ->getMock();

        $mock->expects($this->once())
            ->method('apply')
            ->with('World!')
            ->will($this->returnValue('World!'));

        $rule = new Safe($mock);
        $this->assertSame('World!', $rule->apply('World!'));
    }

    public function testShouldOnlyRunTwiceWithoutLimit()
    {
        $mock = $this->getMockBuilder(RuleInterface::class)
                ->setMethods(['apply'])
                ->getMock();

        $mock->expects($this->exactly(2))
            ->method('apply')
            ->withConsecutive(
                    [$this->equalTo('Hello')],
                    [$this->equalTo('World!')]
            )
            ->will($this->returnValue('World!'));

        $rule = new Safe($mock);
        $this->assertSame('World!', $rule->apply('Hello'));
    }

    public function testShouldStop()
    {
        $mock = $this->getMockBuilder(RuleInterface::class)
                ->setMethods(['apply'])
                ->getMock();

        $mock->expects($this->exactly(2))
                ->method('apply')
                ->withConsecutive(
                        [$this->equalTo('Hello')],
                        [$this->equalTo('World!')]
                )
                ->willReturnOnConsecutiveCalls(
                        $this->returnValue('World!'),
                        $this->returnValue('Bye!')
                );

        $rule = new Safe($mock, 2);
        $this->assertSame('Bye!', $rule->apply('Hello'));
    }

    public function testShouldReturnReplacement()
    {
        $testRule = new Replace('Hello', 'World!');
        $rule = new Safe($testRule);
        $this->assertSame('World!', $rule->apply('Hello'));
    }

}
