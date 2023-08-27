<?php

declare(strict_types=1);

namespace App\Utils;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

        public static function responeJson($content, $status = Response::HTTP_OK, $headers = [])
        {
            return response()
                ->json([
                    'code' => $content['code'] ?? Response::HTTP_NOT_FOUND,
                    'data' => $content['data'] ?? $content,
                    ...$content // xem giải thích bên readme
                ], $status)
                ->header(
                    'Content-Type',
                    'application/json'
                )
                ->withHeaders($headers);
        }

        public static function getDateNow()
        {
            return \Carbon\Carbon::now('Asia/Ho_Chi_Minh');
        }

        public static function getYear()
        {
            return self::getDateNow()->format('Y');
        }

        public static function getMonth()
        {
            return self::getDateNow()->format('m');
        }

        public static function getDate()
        {
            return self::getDateNow()->format('d');
        }

        public static function createFolderByDate()
        {
            return self::getYear() . "/" . self::getMonth() . "/" . self::getDate() .  "/";
        }

        public static function createFolderInPublicByDate($folder)
        {
            $path = public_path("/assets/$folder/" . self::getYear() . "/" . self::getMonth() . "/" . self::getDate() .  "/");
            !file_exists($path) && mkdir($path, 0755, true);

            return $path;
        }

        public static function createFolder($folder)
        {
            return "$folder/";
        }

        public static function createFolderPublic($folder)
        {
            $path = public_path("/assets/$folder/");
            !file_exists($path) && mkdir($path, 0755, true);

            return $path;
        }
    }
}
