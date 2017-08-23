<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 23-8-17
 * Time: 10:15
 */

namespace Rule;

use Srcoder\Normalize\Rule\Words;
use PHPUnit\Framework\TestCase;

class WordsTest extends TestCase
{

    protected $rule1;
    protected $rule2;

    public function setUp()
    {
        $this->rule1 = new Words;
        $this->rule2 = new Words("\trl");
    }

    public function testShouldBeWordsDefault()
    {
        $this->assertSame(" \0Hello\nWorld!\n\t", $this->rule1->apply(" \0hello\nworld!\n\t"));
        $this->assertNotSame(" \0hello\nworld!\n\t", $this->rule1->apply(" \0hello\nworld!\n\t"));
    }

    public function testShouldBeWords()
    {
        $this->assertSame(" \0helLo\nworLd!\n\t", $this->rule2->apply(" \0hello\nworld!\n\t"));
        $this->assertNotSame(" \0hello\nworld!\n\t", $this->rule2->apply(" \0hello\nworld!\n\t"));
    }

}
