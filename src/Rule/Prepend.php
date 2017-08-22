<?php
/**
 * @copyright (c) 2017 Srcode
 */

declare(strict_types=1);

namespace Srcoder\Normalize\Rule;

class Prepend implements RuleInterface
{

    /** @var string */
    protected $prepend;

    public function __construct(string $prepend = '')
    {
        $this->prepend = $prepend;
    }

    /**
     * Apply rule
     *
     * @param string $string
     * @return string
     */
    public function apply(string $string) : string
    {
        return $this->prepend . $string;
    }

}
