<?php

namespace App\Events\Api;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostsEvent extends ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $posts;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($posts)
    {
        $this->posts = $posts;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('posts-get');
    }

    public function broadcastAs()
    {
        return "PostsEvent";
    }

    public function broadcastWith()
    {
        return [
            'posts' => $this->posts,
        ];
    }
}
