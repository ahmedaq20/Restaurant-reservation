import './bootstrap';


// قناة خاصة للإدمن
Echo.private('admin')
    .listen('.new-reservation', (e) => {
        console.log('📣 Event received:', e);
        alert('🟢 New reservation by: ' + e.first_name);
    });
