<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 23-8-17
 * Time: 10:14
 */

namespace Rule;

use Srcoder\Normalize\Rule\Trim;
use PHPUnit\Framework\TestCase;

class TrimTest extends TestCase
{

    protected $rule1;
    protected $rule2;

    public function setUp()
    {
        $this->rule1 = new Trim;
        $this->rule2 = new Trim("!\t");
    }

    public function testShouldBeTrimmedDefaults()
    {
        $this->assertSame('Hello World!', $this->rule1->apply(" \0Hello World!\n\n\t"));
        $this->assertSame("Hello World\t!", $this->rule1->apply("Hello World\t!"));
    }

    public function testShouldBeTrimmed()
    {
        $this->assertSame(" \0Hello World!\n\n", $this->rule2->apply(" \0Hello World!\n\n\t"));
        $this->assertSame("Hello World", $this->rule2->apply("Hello World\t!"));
    }

}
