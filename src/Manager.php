<?php
/**
 * @copyright (c) 2017 Srcode
 */

declare(strict_types=1);

namespace Srcoder\Normalize;

use Srcoder\Normalize\Exception\Exists;
use Srcoder\Normalize\Exception\NotFound;

class Manager
{

    /** @var array */
    protected $instances = [];
    
    /** @var Manager */
    static protected $instance;

    /**
     * Get manager
     *
     * @return Manager
     */
    static public function instance()
    {
        if (null === self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Tell if instance exists
     *
     * @param string $identifier
     * @return bool
     */
    public function exists(string $identifier) : bool
    {
        return isset($this->instances[$identifier]);
    }

    /**
     * Get existing normalize instance 
     *
     * @param string $identifier
     * @return Normalize
     * @throws NotFound
     */
    public function get(string $identifier = '') : Normalize
    {
        if (!$this->exists($identifier)) {
            throw new NotFound("No instance found with the name '{$identifier}'");
        }

        return $this->instances[$identifier];
    }

    /**
     * Add a new instance
     * 
     * @param Normalize $normalize
     * @param string $identifier
     * @param string $chain
     * @return Manager
     * @throws Exists
     */
    public function add(Normalize $normalize, string $identifier = '', string $chain = null) : Manager
    {
        if ($this->exists($identifier)) {
            throw new Exists("Instance with the name '{$identifier}' already exists");
        }

        // Set parent
        null !== $chain && $normalize->setChain($this->get($chain));

        $this->instances[$identifier] = $normalize;
        return $this;
    }

    /**
     * Create new Normalize object
     *
     * @param array $rules
     * @return Normalize
     */
    public function create(array $rules = []) : Normalize
    {
        return new Normalize($rules);
    }

    /**
     * Create and add Normalize object
     *
     * @param array $rules
     * @param string $identifier
     * @param string $chain
     * @return Manager
     */
    public function createAndAdd(array $rules = [], string $identifier = '', string $chain = null) : Manager
    {
        return $this->add($this->create($rules), $identifier, $chain);
    }

}
