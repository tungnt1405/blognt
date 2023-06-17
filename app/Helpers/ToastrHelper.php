<?php

declare(strict_types=1);

namespace App\Helpers;

if (!class_exists('\App\Helpers\ToastrHelper')) {
    class ToastrHelper
    {
        /**
         * @param string $message
         * @param string $title
         * @param array $options
         * 
         * @return Toastr
         */
        public static function toastrSuccess($message, $title = '', array $option = array())
        {
            return toastr()->success($message, $title, $option);
        }

        /**
         * @param string $message
         * @param string $title
         * @param array $options
         * 
         * @return Toastr
         */
        public static function toastrInfo($message, $title = '', array $option = array())
        {
            return toastr()->info($message, $title, $option);
        }

        /**
         * @param string $message
         * @param string $title
         * @param array $options
         * 
         * @return Toastr
         */
        public static function toastrWarning($message, $title = '', array $option = array())
        {
            return toastr()->warning($message, $title, $option);
        }

        /**
         * @param string $message
         * @param string $title
         * @param array $options
         * 
         * @return Toastr
         */
        public static function toastrError($message, $title = '', array $option = array())
        {
            return toastr()->error($message, $title, $option);
        }
    }
}
