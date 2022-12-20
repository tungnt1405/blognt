<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SystemController extends Controller
{
    /**
     * change system language
     * 
     * @param string $language
     */
    public function changeLanguage($language)
    {
        $languages = [
            'en',
            'vi'
        ];
        $current_lang = config('app.locale');

        if(!in_array($language, $languages)){
            $language = $current_lang;
        }

        Session::put('language', $language);

        return back();
    }
}
