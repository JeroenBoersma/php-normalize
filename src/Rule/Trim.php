<?php
/**
 * @copyright (c) 2017 Srcode
 */

declare(strict_types=1);

namespace Srcoder\Normalize\Rule;

class Trim implements RuleInterface
{

    /** @var string */
    protected $charlist;

    public function __construct(string $charlist = " \t\n\r\0\x0B")
    {
        $this->charlist = $charlist;
    }

    /**
     * Apply rule
     *
     * @param string $string
     * @return string
     */
    public function apply(string $string) : string
    {
        return trim($string, $this->charlist);
    }

}
