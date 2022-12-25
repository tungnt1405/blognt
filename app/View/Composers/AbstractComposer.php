<?php

namespace App\View\Composers;

use Illuminate\View\View;

abstract class AbstractComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view){}
}