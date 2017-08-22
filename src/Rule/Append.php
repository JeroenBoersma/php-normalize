<?php
/**
 * @copyright (c) 2017 Srcode
 */

declare(strict_types=1);

namespace Srcoder\Normalize\Rule;

class Append implements RuleInterface
{

    /** @var string */
    protected $append;

    public function __construct(string $append = '')
    {
        $this->append = $append;
    }

    /**
     * Apply rule
     *
     * @param string $string
     * @return string
     */
    public function apply(string $string) : string
    {
        return $string . $this->append;
    }

}
