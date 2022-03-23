<?php

namespace rame0\API\CBRF;

/*
 * @copyright  Copyright (c) Ramil Aliyakberov (http://www.rame0.biz)
 * @author     Ramil Aliyakberov <r@me0.biz>
 */

use ArrayAccess;
use Countable;
use Iterator;
use JsonSerializable;

/**
 * Description of Collection
 *
 * @author me
 */
class Collection implements Iterator, ArrayAccess, Countable, JsonSerializable
{

    /**
     * Collection of objects
     * @var array
     */
    protected array $_collection;

    /**
     * Pointer
     * @var int
     */
    private int $_position = 0;

    /**
     * Collection constructor.
     * @param array|null $collection
     */
    public function __construct(array $collection = null)
    {
        if (empty($collection)) {
            $this->_collection = [];
        } else {
            $this->_collection = $collection;
        }
    }


    // implementation of Iterator, Countable
    public function rewind()
    {
        reset($this->_collection);
        $this->_position = key($this->_collection);
//        $this->_position = 0;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->_collection[$this->_position];
    }

    /**
     * @return int
     */
    public function key(): int
    {
//        $this->_position = key($this->_collection);
        return $this->_position;
    }

    public function next()
    {
        next($this->_collection);
        $this->_position = key($this->_collection);
//        ++$this->_position;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->_collection[$this->_position]);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->_collection);
    }


    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->_collection[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->_collection[$offset] ?? null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if (empty($offset)) {
            $this->add($value);
        } else {
            $this->add($offset, $value);
        }
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->_collection[$offset]);
    }

    /**
     * @return array
     */
    public function getCollection(): array
    {
        return $this->_collection;
    }

    /**
     * @param mixed $key_or_val if second param is NULL, this one will be added like value
     * else, this param will be used as key
     * @param null $value value to add to collection OR NULL if value is given in first parameter
     */
    public function add($key_or_val, $value = null)
    {
        if (is_null($value)) {
            $this->_collection[] = $key_or_val;
        } else {
            $this->_collection[$key_or_val] = $value;
        }
    }


    /**
     * Filters elements in collection using a callback function.<br/>
     * You can use $value and $key that in callback function
     * @param callable $fn
     * @return Collection
     */
    public function filter(callable $fn): Collection
    {
        $filtered = array_filter($this->_collection, $fn, ARRAY_FILTER_USE_BOTH);
        return new self($filtered);

    }


    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->_collection);
    }

    /**
     * @return bool
     */
    public function notEmpty(): bool
    {
        return !empty($this->_collection);
    }

    /**
     * @return array
     */
    public function getKeys(): array
    {
        return array_keys($this->_collection);
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return array_values($this->_collection);
    }

    /**
     * @param string $column_name
     * @param string|null $index_key
     * @return array
     */
    public function getColumn(string $column_name, string $index_key = null): array
    {
        return array_column($this->_collection, $column_name, $index_key);
    }

    /**
     * @return array|null
     */
    public function jsonSerialize(): ?array
    {
        if (empty($this->_collection)) {
            return null;
        }
        $result = [];
        foreach ($this->_collection as $key => $item) {
            $result[$key] = $item->jsonSerialize();
        }
        return $result;
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        if (empty($this->_collection)) {
            return [];
        }
        $result = [];
        foreach ($this->_collection as $key => $item) {
            $result[$key] = $item->asArray();
        }
        return $result;
    }
}
