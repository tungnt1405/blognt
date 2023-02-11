<?php

namespace App\Http\Livewire\Admin\Posts;

use App\Services\Interfaces\Admin\PostsServiceInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Routing\Route;
use Livewire\Component;

class Show extends Component
{
    public $posts, $categories, $title, $slug, $status, $description, $pushDate = null;

    /**
     * @var PostsServiceInterface $postService
     */
    protected $postsService;

    public function mount(PostsServiceInterface $postsService)
    {
        $this->postsService = $postsService;
    }

    public function render()
    {
        $this->posts = $this->postsService->getAllPost();
        return view('livewire.admin.posts.show');
    }
}
