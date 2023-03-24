<?php

namespace App\Http\Livewire\Admin\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.posts.show', []);
    }
}
