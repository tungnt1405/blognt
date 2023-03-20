<?php

namespace App\Http\Livewire\Admin\Posts;

use App\Services\Admin\PostsService;
use App\Services\Interfaces\Admin\PostsServiceInterface;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public $categories, $title, $slug, $status, $description, $pushDate = null;
    public $records = 1;
    public $showFilters = false;
    public $filter = [
        'search' => '',
        'categories' => [],
        'status' => 1
    ];

    /**
     * @var PostsServiceInterface $postService
     */
    // protected $postsService;
    protected $postsService;

    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.admin.posts.show', [
            'posts' => app()->make('PostsService')->paginatePosts($this->records, $this->filter, 1),
            'postsBySoftDelete' => app()->make('PostsService')->getOnlyPostsSoftDelete()
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function searchPosts()
    {
        $this->updatingSearch();
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;

        if (!$this->showFilters) {
            $this->reset('filter');
        }
    }
}
