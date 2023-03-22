<?php

namespace App\Http\Livewire\Admin\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    protected $posts;
    public $categories;
    public $showFilters = false;
    public $isTrash;

    public function render()
    {
        return view('livewire.admin.posts.show', []);
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;

        if (!$this->showFilters) {
            $this->reset('filter');
        }
    }
}
