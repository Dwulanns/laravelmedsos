<?php

use App\Notifications\NewCommentNotification;
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


Broadcast::channel('users.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('conversations.{conversationId}', function ($user, $conversationId) {
    return $user->conversations->contains($conversationId);
});
Broadcast::channel('comments.{postId}', function ($user, $postId) {
    $post = Post::find($postId);
    if ($post && $post->user_id === $user->id) {
        return true;
    }
    $comment = NewCommentNotificationComment::where('post_id', $postId)->where('user_id', $user->id)->first();
    if ($comment) {
        return true;
    }
    return false;
});

Broadcast::channel('messages.{conversationId}', function ($user, $conversationId) {
    // Logic untuk menentukan apakah pengguna memiliki akses ke notifikasi pesan dalam percakapan tertentu
    return true; // Misalnya, sini kamu bisa menambahkan logika untuk menentukan apakah pengguna memiliki akses ke notifikasi pesan dalam percakapan tertentu
});

