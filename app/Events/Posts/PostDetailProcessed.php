<?php

namespace App\Events\Posts;

use App\Services\Interfaces\Api\PostServiceInterface;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostDetailProcessed implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The name of the queue connection to use when broadcasting the event.
     *
     * @var string
     */
    public $connection = 'redis';

    /**
     * The name of the queue on which to place the broadcasting job.
     *
     * @var string
     */
    public $queue = 'default';

    /**
     * The name of the queue on which to place the broadcasting job. (thay cho $queue)
     *
     * @return string
     */
    // public function broadcastQueue()
    // {
    //     return 'default';
    // }

    /**
     * The post instance.
     *
     * @var \App\Services\Interfaces\Api\PostServiceInterface
     */
    public $post;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * Determine if this event should broadcast.
     *
     * @return bool
     */
    public function broadcastWhen()
    {
        return collect($this->post)->count() > 0;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['post.' . $this->post->id];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'post.detail';
    }

    /**
     * Get the data to broadcast. (kiểm soát dữ liệu trả về sẽ có gì)
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            "id" => $this->post->id,
            "author_id" => $this->post->id,
            "category_id" => $this->post->category_id,
            "title" => $this->post->title,
            "slug" => $this->post->slug
        ];
    }
}
