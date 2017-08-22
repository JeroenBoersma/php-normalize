<?php
/**
 * @copyright (c) 2017 Srcode
 */

declare(strict_types=1);

namespace Srcoder\Normalize;

use Srcoder\Normalize\Rule\RuleInterface;

class Normalize
{

    /** @var array  */
    protected $rules = [];

    /** @var array */
    protected $cache = [];

    /** @var Normalize|null */
    protected $chain = null;

    public function __construct(array $rules = [])
    {
        $this->addRules($rules);
    }

    /**
     * Set chain
     *
     * @param Normalize $chain
     * @return Normalize
     */
    public function setChain(Normalize $chain) : Normalize
    {
        $this->chain = $chain;
        return $this;
    }

    /**
     * Return normalized string
     *
     * @param string $string
     * @return string
     */
    public function normalize(string $string) : string
    {
        if (isset($this->cache[$string])) {
            return $this->cache[$string];
        }

        $result = $this->normalizeChain($string);

        $toCache = array_map(function(RuleInterface $rule) use (&$result) {
            return $result = $rule->apply($result);
        }, $this->rules);

        // Add cache for variants
        array_map(function($index) use ($result) {
            $this->cache[$index] = $result;
        }, $toCache);
        $this->cache[$string] = $result;

        return $result;
    }

    /**
     * Normalize parent if exists
     *
     * @param string $string
     * @return string
     */
    protected function normalizeChain(string $string): string
    {
        if (null === $this->chain) {
            return $string;
        }

        return $this->chain
                ->normalize($string);
    }

    /**
     * Add a rule
     *
     * @param array $rules
     * @return Normalize
     */
    public function addRules(array $rules) : Normalize
    {
        array_map([$this, 'addRule'], $rules);
        return $this;
    }

    /**
     * Add a rule
     *
     * @param RuleInterface $rule
     * @return RuleInterface
     */
    public function addRule(RuleInterface $rule) : RuleInterface
    {
        array_push($this->rules, $rule);
        return $rule;
    }

    /**
     * Prepend rules
     *
     * @param array $rules
     * @return Normalize
     */
    public function prependRules(array $rules) : Normalize
    {
        array_map([$this, 'prependRule'], $rules);
        return $this;
    }

    /**
     * Prepend a rule
     *
     * @param RuleInterface $rule
     * @return RuleInterface
     */
    public function prependRule(RuleInterface $rule) : RuleInterface
    {
        array_unshift($this->rules, $rule);
        return $rule;
    }

}
