<?php

namespace App\Providers;

use App\Events\Posts\PostDetailProcessed;
use App\Listeners\SendPostDetailNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Throwable;

use function Illuminate\Events\queueable;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PostDetailProcessed::class => [ // ví dụ về event and listen
            SendPostDetailNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        // khai báo chạy listen ở trên nên có thể bỏ qua chỗ này
        // Event::listen(queueable(function (PostDetailProcessed $event) {
        //     // handle event
        //     Log::debug('debug', [$event]);
        // })->catch(function (PostDetailProcessed $event, Throwable $e) {
        //     // handle fail
        //     Log::error('catch list: ', [$e->getMessage(), $event]);
        // }));
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
