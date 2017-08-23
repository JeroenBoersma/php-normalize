<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 23-8-17
 * Time: 10:15
 */

use Srcoder\Normalize\Manager;
use PHPUnit\Framework\TestCase;

class ManagerTest extends TestCase
{

    public function testInstance()
    {
        $manager = Manager::instance();
        $manager2 = Manager::instance();

        $this->assertSame($manager, $manager2);
    }

    public function testExists()
    {
        $manager = new Manager;
        $manager->add(new Srcoder\Normalize\Normalize, 'test');

        $this->assertTrue($manager->exists('test'));
        $this->assertFalse($manager->exists('notexists'));
    }

    public function testGet()
    {
        $manager = new Manager;
        $normalize = new Srcoder\Normalize\Normalize;

        $manager->add($normalize, 'test');

        $this->assertSame($normalize, $manager->get('test'));
    }

    public function testGetNonExistent()
    {
        $manager = new Manager;
        $normalize = new Srcoder\Normalize\Normalize;

        $manager->add($normalize, 'test');

        $this->expectException(\Srcoder\Normalize\Exception\NotFound::class);
        $manager->get('nonexistent');
    }

    public function testAddExists()
    {
        $manager = new Manager;
        $normalize = new Srcoder\Normalize\Normalize;

        $manager->add($normalize, 'test');

        $this->expectException(\Srcoder\Normalize\Exception\Exists::class);
        $manager->add($normalize, 'test');
    }

    public function testAddChain()
    {
        $manager = new Manager;
        $normalize = new Srcoder\Normalize\Normalize;
        $normalize2 = new Srcoder\Normalize\Normalize;

        $manager->add($normalize, 'test');
        $manager->add($normalize2, 'test2', 'test');

        $this->expectException(\Srcoder\Normalize\Exception\Exists::class);
        $manager->add($normalize2, 'test2');
    }

    public function testCreate()
    {
        $manager = new Manager;
        $this->assertInstanceOf(\Srcoder\Normalize\Normalize::class, $manager->create([]));
    }

    public function testCreateAndAdd()
    {
        $manager = new Manager;
        $normalize = $manager->createAndAdd([], 'test');

        $this->assertInstanceOf(Manager::class, $normalize);
        $this->assertNotSame($normalize, $manager->get('test'));
    }

    public function testCreateAndAddExists()
    {
        $manager = new Manager;
        $manager->createAndAdd([], 'test');

        $this->expectException(\Srcoder\Normalize\Exception\Exists::class);
        $manager->createAndAdd([], 'test');
    }

    public function testChain()
    {
        $rule = $this->getMockBuilder(\Srcoder\Normalize\Rule\RuleInterface::class)
                ->setMethods(['apply'])
                ->getMock();

        $rule->expects($this->once())
                ->method('apply')
                ->with('Hello World!')
                ->will($this->returnValue('Something else!'));

        $manager = new Manager;
        $manager->createAndAdd([$rule], 'test');
        $manager->createAndAdd([], 'test2', 'test');

        $this->assertSame('Something else!', $manager->get('test2')->normalize('Hello World!'));
    }

}
