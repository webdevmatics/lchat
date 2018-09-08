<?php

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

// Broadcast::channel('App.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('lchat', function ($user) {
    return auth()->check();
});

Broadcast::channel('privatechat.{receiverid}', function ($user,$receiverid) {

    return auth()->check();
});

Broadcast::channel('plchat', function ($user) {

    if(auth()->check()){
        return $user;
    }
});
