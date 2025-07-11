<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('d033176dc6cbebadda9f', {
      cluster: 'ap2'
    });

    var channel = pusher.subscribe('reservations');
    channel.bind('NewReservationCreated', function(data) {
      alert(JSON.stringify(data));
    });
  </script>
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p>
</body>
