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

        public function setCacheForRedis($key, $content)
        {
            return Redis::set($key, $content);
        }

        public function getCacheFromRedis($key)
        {
            return Redis::get($key);
        }
    }
}
