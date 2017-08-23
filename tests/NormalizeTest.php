<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 23-8-17
 * Time: 11:09
 */

use Srcoder\Normalize\Normalize;
use PHPUnit\Framework\TestCase;

class NormalizeTest extends TestCase
{

    public function testNormalize()
    {
        $normalize = new Normalize;
        $this->assertSame('test', $normalize->normalize('test'));
    }

    public function testChainAndCache()
    {
        $normalize = new Normalize;
        $mockChain = $this->getMockBuilder(Normalize::class)
                ->setMethods(['normalize'])
                ->getMock();

        $mockChain->expects($this->once())
                ->method('normalize')
                ->with('Hello World!')
                ->will($this->returnValue('Something else!'));

        $normalize->setChain($mockChain);

        $this->assertSame('Something else!', $normalize->normalize('Hello World!'));
        $this->assertSame('Something else!', $normalize->normalize('Hello World!'));
    }

    public function testNormalizeChain()
    {
        $normalize = new Normalize;
        $mockChain = $this->getMockBuilder(Normalize::class)
                ->setMethods(['normalizeChain'])
                ->getMock();

        $mockChain->expects($this->once())
                ->method('normalizeChain')
                ->with('Hello World!')
                ->will($this->returnValue('Something else!'));

        $normalize->setChain($mockChain);

        $this->assertSame('Something else!', $normalize->normalize('Hello World!'));
        $this->assertSame('Something else!', $normalize->normalize('Hello World!'));
    }


    public function testAddRule()
    {
        $ruleMock = $this->getMockBuilder(\Srcoder\Normalize\Rule\RuleInterface::class)
                ->setMethods(['apply'])
                ->getMock();

        $ruleMock->expects($this->once())
                ->method('apply')
                ->with('Hello World!')
                ->will($this->returnValue('Something else!'));

        $normalize = new Normalize;
        $normalize->addRule($ruleMock);

        $this->assertSame('Something else!', $normalize->normalize('Hello World!'));
    }

    public function testAddRules()
    {
        $ruleMock = $this->getMockBuilder(\Srcoder\Normalize\Rule\RuleInterface::class)
                ->setMethods(['apply'])
                ->getMock();

        $normalizeMock = $this->getMockBuilder(Normalize::class)
                ->setMethods(['addRule'])
                ->getMock();

        $normalizeMock->expects($this->once())
                ->method('addRule')
                ->with($this->identicalTo($ruleMock))
                ->will($this->returnValue($ruleMock));

        $normalizeMock->addRules([$ruleMock]);
    }

    public function testPrependRule()
    {
        $ruleMock = $this->getMockBuilder(\Srcoder\Normalize\Rule\RuleInterface::class)
                ->setMethods(['apply'])
                ->getMock();

        $ruleMock->expects($this->once())
                ->method('apply')
                ->with('Hello World!')
                ->will($this->returnValue('Something else!'));

        $normalize = new Normalize;
        $normalize->prependRule($ruleMock);

        $this->assertSame('Something else!', $normalize->normalize('Hello World!'));
    }

    public function testPrependRules()
    {
        $ruleMock = $this->getMockBuilder(\Srcoder\Normalize\Rule\RuleInterface::class)
                ->setMethods(['apply'])
                ->getMock();

        $normalizeMock = $this->getMockBuilder(Normalize::class)
                ->setMethods(['prependRule'])
                ->getMock();

        $normalizeMock->expects($this->once())
                ->method('prependRule')
                ->with($this->identicalTo($ruleMock))
                ->will($this->returnValue($ruleMock));

        $normalizeMock->prependRules([$ruleMock]);
    }

    public function testRuleOrderAppend()
    {
        $ruleMock1 = $this->getMockBuilder(\Srcoder\Normalize\Rule\RuleInterface::class)
                ->setMethods(['apply'])
                ->getMock();

        $ruleMock1->expects($this->once())
                ->method('apply')
                ->with('Hello World!')
                ->will($this->returnValue('Hello!'));

        $ruleMock2 = $this->getMockBuilder(\Srcoder\Normalize\Rule\RuleInterface::class)
                ->setMethods(['apply'])
                ->getMock();

        $ruleMock2->expects($this->once())
                ->method('apply')
                ->with('Hello!')
                ->will($this->returnValue('Something else!'));

        $normalize = new Normalize;
        $normalize->addRule($ruleMock1);
        $normalize->addRule($ruleMock2);

        $this->assertSame('Something else!', $normalize->normalize('Hello World!'));
    }

    public function testRuleOrderPrepend()
    {
        $ruleMock1 = $this->getMockBuilder(\Srcoder\Normalize\Rule\RuleInterface::class)
                ->setMethods(['apply'])
                ->getMock();

        $ruleMock1->expects($this->once())
                ->method('apply')
                ->with('Something else!')
                ->will($this->returnValue('Hello!'));

        $ruleMock2 = $this->getMockBuilder(\Srcoder\Normalize\Rule\RuleInterface::class)
                ->setMethods(['apply'])
                ->getMock();

        $ruleMock2->expects($this->once())
                ->method('apply')
                ->with('Hello World!')
                ->will($this->returnValue('Something else!'));

        $normalize = new Normalize;
        $normalize->addRule($ruleMock1);
        $normalize->prependRule($ruleMock2);

        $this->assertSame('Hello!', $normalize->normalize('Hello World!'));
    }

}
