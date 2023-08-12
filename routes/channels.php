<?php

use App\Broadcasting\Posts\PostDetailChannel;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/**
 * replace PostChannel
//  function ($id) {
//     Log::debug('broadcase channel post.{id}== ' . $id);
//     return (int) $id == Post::findOrFail($id)->id;
// }
 */
Broadcast::channel('post.{id}', PostDetailChannel::class);
