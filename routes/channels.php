<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('admin', function ($user) {
    // هنا نسمح فقط للـ Admin
    return $user->is_admin === true;
});