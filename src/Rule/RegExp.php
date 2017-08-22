<?php
/**
 * @copyright (c) 2017 Srcode
 */

declare(strict_types=1);

namespace Srcoder\Normalize\Rule;

class RegExp implements RuleInterface
{
    /** @var string */
    protected $pattern;
    /** @var string */
    protected $replacement;

    public function __construct(string $pattern, string $replacement)
    {
        $this->pattern = $pattern;
        $this->replacement = $replacement;
    }

    /**
     * Apply rule
     *
     * @param string $string
     * @return string
     */
    public function apply(string $string) : string
    {
        return preg_replace($this->pattern, $this->replacement, $string);
    }

}