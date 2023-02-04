<?php

namespace App\Http\Livewire\Admin\SideBar;

use Livewire\Component;

class MoreInfo extends Component
{
    public $owner;
    public function render()
    {
        return view('livewire.admin.side-bar.more-info', []);
    }
}
