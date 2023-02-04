<?php

namespace App\View\Composers;

use App\Repositories\Admin\OwnerRepository;
use Illuminate\View\View;

class OwnerComposer extends AbstractComposer
{
    /**
     * @var \App\Repositories\Admin\OwnerRepository
     */
    protected $_ownerRepository;

    /**
     * Create a new country composer.
     * 
     * @param \App\Repositories\Admin\OwnerRepository $_ownerRepository
     * 
     * @return void
     */
    public function __construct(OwnerRepository $_ownerRepository)
    {
        $this->_ownerRepository = $_ownerRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('allOwner', $this->_ownerRepository->getFirstRecord());
    }
}
