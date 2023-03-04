<?php

namespace App\Http\Livewire\Admin\Posts;

use App\Services\Interfaces\Admin\CategoryServiceInterface;
use Livewire\Component;

class Create extends Component
{
    public $categories;

    public function render()
    {
        return view('livewire.admin.posts.create', []);
    }
}
