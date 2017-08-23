<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 23-8-17
 * Time: 11:10
 */

use Srcoder\Normalize\NormalizeTrait;
use PHPUnit\Framework\TestCase;

class NormalizeTraitTest extends TestCase
{

    protected function getTrait()
    {
        return $this->getMockForTrait(NormalizeTrait::class);
    }

    protected function getRule()
    {
        return $this->getMockBuilder(\Srcoder\Normalize\Rule\RuleInterface::class)
                ->setMethods(['apply'])
                ->getMock();
    }

    public function testNotInitialized()
    {
        $trait = $this->getTrait();
        $this->expectException(TypeError::class);
        $trait->normalizer();
    }

    public function testInitialize()
    {
        $trait = $this->getTrait();
        $this->assertInstanceOf(\Srcoder\Normalize\Normalize::class, $trait->normalizerInit());
    }

    public function testReset()
    {
        $trait = $this->getTrait();
        $this->assertNotSame($trait->normalizerInit(), $trait->normalizerReset());
    }

    public function testNormalizer()
    {
        $trait = $this->getTrait();
        $normalizer = $trait->normalizerInit();
        $this->assertSame($normalizer, $trait->normalizer());
    }

    public function testAddNormalizeRule()
    {
        $trait = $this->getTrait();
        $trait->normalizerInit();

        $rule = $this->getRule();
        $this->assertSame($rule, $trait->addNormalizeRule($rule));
    }

    public function testAddNormalizeRules()
    {
        $trait = $this->getTrait();
        $normalize = $trait->normalizerInit();

        $this->assertSame($normalize, $trait->addNormalizeRules([$this->getRule()]));
    }


    public function testPrependNormalizeRule()
    {
        $trait = $this->getTrait();
        $trait->normalizerInit();

        $rule = $this->getRule();
        $this->assertSame($rule, $trait->prependNormalizeRule($rule));
    }

    public function testPrependNormalizeRules()
    {
        $trait = $this->getTrait();
        $normalize = $trait->normalizerInit();

        $this->assertSame($normalize, $trait->prependNormalizeRules([$this->getRule()]));
    }

    public function testNormalize()
    {
        $trait = $this->getTrait();
        $trait->normalizerInit();

        $this->assertSame('Hello World!', $trait->normalize('Hello World!'));
    }

    public function testNormalizeOrderAppend()
    {
        $trait = $this->getTrait();
        $trait->normalizerInit();

        $rule1 = $this->getRule();
        $rule1->expects($this->once())
                ->method('apply')
                ->with('Hello World!')
                ->will($this->returnValue('Something else!'));

        $rule2 = $this->getRule();
        $rule2->expects($this->once())
                ->method('apply')
                ->with('Something else!')
                ->will($this->returnValue('Hello!'));

        $trait->addNormalizeRule($rule1);
        $trait->addNormalizeRule($rule2);

        $this->assertSame('Hello!', $trait->normalize('Hello World!'));
    }

    public function testNormalizeOrderPrepend()
    {
        $trait = $this->getTrait();
        $trait->normalizerInit();

        $rule1 = $this->getRule();
        $rule1->expects($this->once())
                ->method('apply')
                ->with('Hello!')
                ->will($this->returnValue('Hello World!'));

        $rule2 = $this->getRule();
        $rule2->expects($this->once())
                ->method('apply')
                ->with('Something else!')
                ->will($this->returnValue('Hello!'));

        $trait->addNormalizeRule($rule1);
        $trait->prependNormalizeRule($rule2);

        $this->assertSame('Hello World!', $trait->normalize('Something else!'));
    }

}
