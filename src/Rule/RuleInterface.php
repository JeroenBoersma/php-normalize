<?php
/**
 * @copyright (c) 2017 Srcode
 */

declare(strict_types=1);

namespace Srcoder\Normalize\Rule;

interface RuleInterface
{

    /**
     * Apply rule
     *
     * @param string $string
     * @return string
     */
    public function apply(string $string) : string;

}
