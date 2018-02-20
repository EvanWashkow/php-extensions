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
    
    
    final public function __construct( array $items = [], bool $markCacheComplete = false )
    {
        $this->set( $items, $markCacheComplete );
    }
    
    
    /***************************************************************************
    *                             CACHE OPERATIONS
    ***************************************************************************/
    
    final public function add( $key, $value )
    {
        $key = self::sanatizeKey( $key );
        if ( !$this->isSet( $key )) {
            $key = $this->update( $key, $value );
        }
        return $key;
    }
    
    
    final public function clear()
    {
        $this->cache = [];
        $this->markIncomplete();
    }
    
    
    final public function delete( $key )
    {
        if ( $this->isSet( $key )) {
            $key = self::sanatizeKey( $key );
            unset( $this->cache[ $key ] );
        }
        else {
            $key = NULL;
        }
        return $key;
    }
    
    
    final public function get( $key = NULL )
    {
        // Variables
        $value = NULL;
        
        // No key specified: return entire cache.
        if ( !isset( $key )) {
            $value = $this->cache;
        }
        
        // Retrieve value from key
        elseif ( $this->isSet( $key )) {
            $key   = self::sanatizeKey( $key );
            $value = $this->cache[ $key ];
        }
        
        return $value;
    }
    
    
    final public function update( $key, $value )
    {
        $key = self::sanatizeKey( $key );
        if ( isset( $key )) {
            $this->cache[ $key ] = $value;
        }
        return $key;
    }
    
    
    final public function set( array $items, bool $markCacheComplete = true )
    {
        $this->clear();
        foreach ( $items as $key => $value) {
            $this->update( $key, $value );
        }
        if ( $markCacheComplete ) {
            $this->markComplete();
        }
        else {
            $this->markIncomplete();
        }
    }
    
    
    /***************************************************************************
    *                                CACHE STATUS
    ***************************************************************************/
    
    final public function isSet( $key )
    {
        $key = self::sanatizeKey( $key );
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
}