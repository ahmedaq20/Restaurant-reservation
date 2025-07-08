import './bootstrap';

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

Echo.channel('reservations')
    .listen('.new-reservation', (e) => {
        console.log('📣 Event received:', e);
        alert('🟢 New reservation by: ' + e.reservation.first_name);
    });
