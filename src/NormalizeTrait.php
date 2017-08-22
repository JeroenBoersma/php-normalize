<?php

declare(strict_types=1);

namespace Srcoder\Normalize;

use Srcoder\Normalize\Rule\RuleInterface;

trait NormalizeTrait
{

    /** @var Normalize */
    protected $normalizer;

    /**
     * Init normalizer
     *
     * @return Normalize
     */
    public function normalizerInit() : Normalize
    {
        return $this->normalizer = new Normalize();
    }

    /**
     * Reset normalizer
     *
     * @return Normalize
     */
    public function normalizerReset() : Normalize
    {
        $this->normalizer = null;
        return $this->normalizerInit();
    }

    /**
     * Get normalizer
     *
     * @return Normalize
     */
    public function normalizer() : Normalize
    {
        return $this->normalizer;
    }

    /**
     * Add rules
     *
     * @param RuleInterface[] $rules
     * @return Normalize
     */
    public function addNormalizeRules(array $rules) : Normalize
    {
        return $this->normalizer()
                ->addRules($rules);
    }

    /**
     * Add rule
     *
     * @param RuleInterface $rule
     * @return RuleInterface
     */
    public function addNormalizeRule(RuleInterface $rule) : RuleInterface
    {
        return $this->normalizer()
                ->addRule($rule);
    }

    /**
     * Prepend rules
     *
     * @param RuleInterface[] $rules
     * @return Normalize
     */
    public function prependNormalizeRules(array $rules) : Normalize
    {
        return $this->normalizer()
                ->prependRules($rules);
    }

    /**
     * Prepend rule
     *
     * @param RuleInterface $rule
     * @return RuleInterface
     */
    public function prependNormalizeRule(RuleInterface $rule) : RuleInterface
    {
        return $this->normalizer()
                ->prependRule($rule);
    }

    /**
     * Normalize string
     *
     * @param string $name
     * @return string
     */
    public function normalize(string $name) : string
    {
        return $this->normalizer()
                ->normalize($name);
    }

}


