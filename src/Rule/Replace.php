<?php
/**
 * @copyright (c) 2017 Srcode
 */

declare(strict_types=1);

namespace Srcoder\Normalize\Rule;

class Replace implements RuleInterface
{
    /** @var mixed */
    protected $search;
    /** @var mixed */
    protected $replace;

    public function __construct($search, $replace)
    {
        $this->search = $search;
        $this->replace = $replace;
    }

    /**
     * Apply rule
     *
     * @param string $string
     * @return string
     */
    public function apply(string $string) : string
    {
        return str_replace($this->search, $this->replace, $string);
    }

}