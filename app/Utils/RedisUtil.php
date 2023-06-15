<?php

declare(strict_types=1);

namespace App\Utils;

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

        public static function setKey($key, $data)
        {
            return Redis::set($key, $data);
        }

        public static function getKey($key)
        {
            return Redis::get($key);
        }

        public static function addOrUpdateForKey($key, $data)
        {
            return Redis::sadd($key, $data);
        }

        public static function allValueOfKey($key)
        {
            return Redis::smember($key);
        }

        public static function setMultipleForHashList($key, $data)
        {
            return Redis::hmset($key, $data);
        }

        public static function getAllOfHashList($key)
        {
            return Redis::hgetall($key);
        }

        public static function addValueToFirstForList($key, $value)
        {
            return Redis::lpush($key, $value);
        }

        public static function addValueToLastedForList($key, $value)
        {
            return Redis::rpush($key, $value);
        }

        public static function scopeRangeInList($key, $start, $stop)
        {
            return Redis::lrange($key, $start, $stop);
        }

        public static function sortedKey($key, $va)
        {
        }
    }
}
