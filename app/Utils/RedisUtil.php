<?php

declare(strict_types=1);

namespace App\Utils;

use Exception;
use Illuminate\Support\Facades\Redis;

if (!class_exists('\App\Utils\RedisUtil')) {
    class RedisUtil
    {
        protected $redis;

        public function __invoke()
        {
            try {
                $this->redis = Redis::connection();
            } catch (\Exception $e) {
                return response($e->getMessage());
            }
        }

        /**
         * Used to set the value for a key.
         * 
         * @param string $key
         * @param string $data
         * @param number $time
         * @return mixed
         */
        public static function setKey($key, $data, $time = 0)
        {
            if (isset($time)) {
                return Redis::set($key, $data, $time);
            }
            return Redis::set($key, $data);
        }

        /**
         * Used to retrieve the value of a key.
         * 
         * @param string $key
         * @return mixed
         */
        public static function getKey($key)
        {
            return Redis::get($key);
        }

        /**
         * Delete key in redis
         * 
         * @param string $key
         * @return mixed
         */
        public static function deleteKey($key)
        {
            return Redis::del($key);
        }

        /**
         * Set the value for a field in a Hash.
         * 
         * @param string $key
         * @param string $field
         * @param string $value
         * @return mixed
         */
        public static function hashSetKey($key, $field, $value)
        {
            return Redis::hset($key, $field, $value);
        }

        /**
         * Get the value of a field in a Hash.
         * 
         * @param string $key
         * @param string $field
         * @return mixed
         */
        public static function hashGetKey($key, $field)
        {
            return Redis::hGet($key, $field);
        }

        /**
         * Used to retrieve all elements in a Set.
         * 
         * @param string $key
         * @param array|mixed $data
         * @return mixed
         */
        public static function addOrUpdateForKey($key, $data)
        {
            if (is_array($data)) {
                return Redis::sadd($key, ...$data);
            }
            return Redis::sadd($key, $data);
        }

        /**
         * Used to retrieve all elements in a Set.
         * 
         * @param string $key
         * @return mixed
         */
        public static function allValueOfKey($key)
        {
            return Redis::smembers($key);
        }

        /**
         * Used to set multiple fields and values for a Hash in a single call.
         * 
         * @param string $key
         * @param array $data
         * @return mixed
         */
        public static function setMultipleForHashList($key, $data)
        {
            return Redis::hmset($key, $data);
        }

        /**
         * Used to retrieve all fields and values of a Hash.
         * 
         * @param string $key
         * @return mixed
         */
        public static function getAllOfHashList($key)
        {
            return Redis::hgetall($key);
        }

        /**
         * Used to add one or more elements to the beginning of a List
         * 
         * @param string $key
         * @param array|mixed $value
         * @return mixed
         */
        public static function addValueToFirstForList($key, $value)
        {
            if (is_array($value)) {
                return Redis::lpush($key, ...$value);
            }
            return Redis::lpush($key, $value);
        }

        /**
         * Add one or more elements to the end of a List.
         * 
         * @param string $key
         * @param mixed $value
         * @return mixed
         */
        public static function addValueToLastedForList($key, $value)
        {
            return Redis::rpush($key, $value);
        }

        /**
         * Return a set of elements from a List, specifying the start and end index of the set of elements to retrieve, 
         * or retrieve the entire set of elements.
         * 
         * @param string $key
         * @param number $start
         * @param number $stop
         * @return mixed
         */
        public static function scopeRangeInList($key, $start, $stop = -1)
        {
            return Redis::lrange($key, $start, $stop);
        }

        /**
         * Sort by the score passed in.
         * 
         * @param string $list
         * @param array|number $sort
         * @param string $key
         * @return mixed
         */
        public static function sortedLists($list, $sort, $key = '')
        {
            if (collect($sort)->isNotEmpty() && empty($key)) {
                return Redis::zadd($list, $sort);
            } elseif (!empty($key)) {
                return Redis::zadd($list, $sort, $key);
            }

            throw new Exception(trans('validation.exception.sorted_invalid_error'));
        }

        /**
         * Range of start to end to retrieve elements that are within the key.
         * 
         * @param string $key
         * @param number $start
         * @param number $end
         * @param boolean $getKeyValue
         * @return mixed
         */
        public static function sortRangeList($key, $start, $end = -1, $getKeyValue = true)
        {
            return Redis::zrange($key, $start, $end, $getKeyValue);
        }

        /**
         * Increase the value of a key by a specific value.
         * 
         * @param string $key
         * @param number $value
         * @return mixed
         */
        public static function increaseByKey($key, $value = 0)
        {
            return Redis::incrby($key, $value);
        }

        /**
         * Decrease the value of a key by a specific value.
         * 
         * @param string $key
         * @param number $value
         * @return mixed
         */
        public static function decreaseByKey($key, $value = 0)
        {
            return Redis::decrby($key, $value);
        }
    }
}
