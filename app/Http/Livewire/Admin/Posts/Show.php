<?php

namespace App\Http\Livewire\Admin\Posts;

use App\Services\Interfaces\Admin\PostsServiceInterface;
use Livewire\Component;

class Show extends Component
{
    public $posts, $postsBySoftDelete;
    public $categories, $title, $slug, $status, $description, $pushDate = null;
    public $records = 15;
    public $showFilters = false;
    public $filter = [
        'search' => '',
        'categories' => [],
        'status' => 1
    ];

    /**
     * @var PostsServiceInterface $postService
     */
    protected $postsService;

    public function mount(PostsServiceInterface $postsService)
    {
        $this->postsService = $postsService;

        $this->posts = $this->postsService->getAllPost();
        $this->postsBySoftDelete = $this->postsService->getOnlyPostsSoftDelete();
    }

    public function render()
    {
        return view('livewire.admin.posts.show', ['posts' => $this->posts]);
    }

    public function searchPosts()
    {
        $this->postsService = app()->make(PostsServiceInterface::class);
        $this->posts = $this->postsService->paginatePosts($this->records, $this->filter);
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;

        if (!$this->showFilters) {
            $this->reset('filter');
        }
    }
}
