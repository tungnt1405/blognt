<?php

declare(strict_types=1);

namespace App\Utils;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

if (!class_exists('\App\Utils\CommonUtil')) {
    class CommonUtil
    {
        public static function isEnvLocalOrTest()
        {
            return app()->environment(['local', 'test']);
        }

        public static function isEnvStaging()
        {
            return app()->environment(['staging']);
        }

        public static function isEnvProd()
        {
            return app()->environment(['production']);
        }

        public static function newCache()
        {
            Artisan::call('config:clear');
            Artisan::call('config:cache');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            Artisan::call('route:cache');
            Artisan::call('cache:clear');
            Cache::flush();
        }

        public static function clearOptimizeCache()
        {
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            Artisan::call('config:clear');
            Cache::flush();
        }

        public static function displayError($message, $title = 'Error')
        {
            if (empty($message)) {
                throw new Exception('validation.utils.common.data_empty');
            }

            Log::error("{$title}: {$message}");
            if (self::isEnvLocalOrTest()) {
                throw new Exception("$title: $message");
            }
            abort(500);
        }
    }
}
