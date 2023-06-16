<?php

declare(strict_types=1);

namespace App\Utils;

use Closure;

if (!class_exists('\App\Utils\TestUtil')) {
    class TestUtil
    {
        /**
         * Tham khảo: https://viblo.asia/p/lambda-closure-va-callback-trong-php-3Q75wEp3ZWb#_2-closure-1
         */
        public static function test($callback)
        {
            return call_user_func($callback);
        }

        public static function test1($callback, ...$args)
        {
            return $callback(...$args);
        }

        /**
         * 1 cách gọi Closure để dùng thay vì dùng trait Closure như test2 trong đây
         * function (argument) use (scope) {
         *      //code
         *   }
         */
        public static function test2(Closure $callback)
        {
            return $callback;
        }

        public static function test3($callback)
        {
            return $callback();
        }
    }
}
