<?php
/**
 * @copyright (c) 2017 Srcode
 */

declare(strict_types=1);

namespace Srcoder\Normalize\Rule;

class Safe implements RuleInterface
{

    /** @var RuleInterface */
    protected $rule;
    /** @var int */
    protected $limit;

    public function __construct(RuleInterface $rule, int $limit = -1)
    {
        $this->rule = $rule;
        $this->limit = $limit;
    }

    /**
     *
     * @param string $string
     * @return string
     */
    public function apply(string $string) : string
    {
        $limit = $this->limit;
        while (($result = $this->rule->apply($string)) != $string && ($limit === -1 || --$limit > -1)) {
            $string = $result;
        }

        return $result;
    }

}
