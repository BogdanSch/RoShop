<?php

namespace kirillbdev\WCUkrShipping\Http\Response;

use kirillbdev\WCUkrShipping\Contracts\ApiResponseInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class CollectionResponse implements ApiResponseInterface, \Iterator
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var int
     */
    protected $index;

    /**
     * @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->index = 0;
    }

    /**
     * @return bool
     */
    public function hasErrors()
    {
        return false;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return count($this->data);
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->data[ $this->index ];
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        ++$this->index;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->data[ $this->index ]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->index = 0;
    }
}