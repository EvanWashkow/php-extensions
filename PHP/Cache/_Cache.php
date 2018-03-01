<?php
namespace PHP\Cache;

/**
 * Defines a basic structure for all Cache implementations
 */
abstract class _Cache
{
    /**
     * Create new cache instance
     */
    abstract public function __construct();
    
    
    /***************************************************************************
    *                             CACHE OPERATIONS
    ***************************************************************************/
    
    
    /**
     * Clear the cache
     *
     * Restores cache to its initial, default state.
     */
    abstract public function clear();
    
    
    /**
     * Remove an item from the cache
     *
     * @param int|string $key Key the value is stored at
     * @return mixed Sanitized key. NULL on failure.
     */
    abstract public function delete( $key );
    
    
    /**
     * Retrieve cached value(s)
     *
     * @param int|string $key Key the value is stored at
     * @return mixed Array if $key is NULL
     */
    abstract public function get( $key = NULL );
    
    
    /**
     * Cache a value
     *
     * @param int|string $key   Key to store the value at
     * @param mixed      $value The value to store
     * @return int|string Sanitized key. NULL on failure.
     */
    abstract public function set( $key, $value );
    
    
    /***************************************************************************
    *                                CACHE STATUS
    ***************************************************************************/
    
    /**
     * Is the cache key set?
     *
     * Does not check to see if $value is NULL: NULL is considered valid.
     *
     * @param int|string $key Key to store the value at
     * @return bool
     */
    abstract public function isSet( $key );
    
    
    /**
     * Has this cache been marked complete?
     *
     * Useful for flagging an interative cache as "complete", to prevent further
     * lookups.
     *
     * @return bool
     */
    abstract public function isComplete();
    
    
    /**
     * Mark cache as complete
     *
     * Useful for flagging an interative cache as "complete", to prevent further
     * lookups.
     */
    abstract public function markComplete();
    
    
    /**
     * Mark cache as incomplete
     *
     * Useful for flagging an interative cache as "complete", to prevent further
     * lookups.
     */
    abstract public function markIncomplete();
}
