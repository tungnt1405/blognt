<?php

namespace App\View\Composers;

use App\Services\Admin\CountryService;
use Illuminate\View\View;

class CountryComposer extends AbstractComposer
{
    /**
     * @var \App\Services\Admin\CountryService
     */
    protected $_countryService;

    /**
     * Create a new country composer.
     * 
     * @param \App\Services\Admin\CountryService $countryService
     * 
     * @return void
     */
    public function __construct(CountryService $countryService)
    {
        $this->_countryService = $countryService;
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('countries', $this->_countryService->all());
    }
}
