<?php

namespace App\Listeners;

use App\Events\Posts\PostDetailProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendPostDetailNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * The number of times the queued listener may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 5;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the name of the listener's queue connection.
     *
     * @return string
     */
    public function viaConnection()
    {
        // /**
        //  * The name of the connection the job should be sent to.
        //  *
        //  * @var string|null
        //  */
        // public $connection = 'redis';
        return 'redis';
    }

    /**
     * Get the name of the listener's queue.
     *
     * @return string
     */
    public function viaQueue()
    {
        // /**
        //  * The name of the queue the job should be sent to.
        //  *
        //  * @var string|null
        //  */
        // public $queue = 'default';
        // thay thế function này
        return 'default';
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Posts\PostDetailProcessed  $event
     * @return void
     */
    public function handle(PostDetailProcessed $event)
    {
        Log::debug('debug listen send', ['id' => $event->post->id, 'title' => $event->post->title]);
    }

    /**
     * Handle a job failure.
     *
     * @param  \App\Events\Posts\PostDetailProcessed  $event
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(PostDetailProcessed $event, $exception)
    {
        Log::error('Send job failed!: ', ['id' => $event->post->id, 'title' => $event->post->title]);
        Log::error('Message ', [$exception->getMessage()]);
    }
}
