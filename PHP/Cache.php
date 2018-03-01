<?php
namespace PHP;

/**
 * Caches and retrieves items from system memory
 */
class Cache extends Cache\_Cache
{
    /**
     * Memory cache
     *
     * @var array
     */
    protected $cache;
    
    /**
     * Are the items in this cache complete?
     *
     * @var bool
     */
    protected $isComplete;
    
    
    final public function __construct()
    {
        $this->cache = [];
    }
    
    
    /***************************************************************************
    *                             CACHE OPERATIONS
    ***************************************************************************/
    
    
    final public function clear()
    {
        $this->cache = [];
        $this->markIncomplete();
    }
    
    
    final public function delete( $key )
    {
        if ( $this->isSet( $key )) {
            $key = self::sanitizeKey( $key );
            unset( $this->cache[ $key ] );
        }
        else {
            $key = NULL;
        }
        return $key;
    }
    
    
    final public function get( $key )
    {
        // Variables
        $value = NULL;
        
        // No key specified: return entire cache.
        if ( !isset( $key )) {
            $value = $this->cache;
        }
        
        // Retrieve value from key
        elseif ( $this->isSet( $key )) {
            $key   = self::sanitizeKey( $key );
            $value = $this->cache[ $key ];
        }
        
        return $value;
    }
    
    
    final public function set( $key, $value )
    {
        $key = self::sanitizeKey( $key );
        if ( isset( $key )) {
            $this->cache[ $key ] = $value;
        }
        return $key;
    }
    
    
    /***************************************************************************
    *                                CACHE STATUS
    ***************************************************************************/
    
    final public function isSet( $key )
    {
        $key = self::sanitizeKey( $key );
        return ( isset( $key ) && array_key_exists( $key, $this->cache ));
    }
    
    
    final public function isComplete()
    {
        return $this->isComplete;
    }
    
    
    final public function markComplete()
    {
        $this->isComplete = true;
    }
    
    
    final public function markIncomplete()
    {
        $this->isComplete = false;
    }
    
    
    /***************************************************************************
    *                                STATIC HELPERS
    ***************************************************************************/
    
    /**
     * Sanitize the cache key
     *
     * @param mixed $key The cache key
     * @return mixed NULL will be returned if invalid
     */
    final protected static function sanitizeKey( $key )
    {
        $type = gettype( $key );
        
        // Sanatize strings; attempting to convert strings to integers
        if ( 'string' == $type ) {
            $key = trim( $key );
            if ( 0 !== intval( $key )) {
                $key = intval( $key );
            }
            elseif ( '0' == $key ) {
                $key = 0;
            }
            elseif ( '' == $key ) {
                $key = NULL;
            }
        }
        
        // Set key as invalid
        elseif ( 'integer' != $type ) {
            $key = NULL;
        }
        
        return $key;
    }
}
