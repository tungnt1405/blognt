<?php

namespace App\Http\Livewire\Admin\SideBar;

use App\Models\Owner;
use Livewire\Component;

class Show extends Component
{
    public function render()
    {
        return view('livewire.admin.side-bar.show', [
            'owner' => Owner::first()
        ]);
    }
}
