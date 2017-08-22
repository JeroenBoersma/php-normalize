<?php
/**
 * @copyright (c) 2017 Srcode
 */

declare(strict_types=1);

namespace Srcoder\Normalize\Rule;

class Words implements RuleInterface
{

    /** @var string */
    protected $delimiters;

    public function __construct(string $delimiters = " \t\n\r\0\x0B")
    {
        $this->delimiters = $delimiters;
    }

    /**
     * Apply rule
     *
     * @param string $string
     * @return string
     */
    public function apply(string $string) : string
    {
        return ucwords($string, $this->delimiters);
    }

}
