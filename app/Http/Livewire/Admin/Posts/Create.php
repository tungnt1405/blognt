<?php

namespace App\Http\Livewire\Admin\Posts;

use App\Services\Interfaces\Admin\CategoryServiceInterface;
use Livewire\Component;

class Create extends Component
{
    public $post, $categories, $listPosts;
    public $checkPost = false;

    public function render()
    {
        return view('livewire.admin.posts.create', []);
    }
}
