<?php

namespace App\Broadcasting\Posts;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class PostDetailChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  mixed  $id
     * @return array|bool
     */
    public function join($id)
    {
        Log::debug('broadcase channel post.{id}== ' . $id);
        return (int) $id == Post::findOrFail($id)->id;
    }
}
