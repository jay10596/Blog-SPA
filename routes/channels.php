<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('removeLikeChannel', function () {
    return true;
});

Broadcast::channel('removeReplyChannel', function () {
    return true;
});

Broadcast::channel('favouriteChannel', function () {
    return true;
});