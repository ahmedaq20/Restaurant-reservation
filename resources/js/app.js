import './bootstrap';

// Check if Echo is defined (it should be, coming from bootstrap.js)
if (typeof Echo !== 'undefined') {
    // Check if a user is authenticated (essential for private channels)
    // You might need to expose a global variable or use a meta tag for user ID
    // For simplicity, let's assume `Auth.user_id` is available globally if you pass it from Blade
    // Or, more robustly, rely on Laravel's broadcasting authentication to handle session.

    // Get DOM elements
    const notificationList = document.getElementById('notification-list');
    const notificationBadge = document.getElementById('notification-badge');
    const notificationCount = document.getElementById('notification-count');

    // Ensure the elements exist before proceeding
    if (notificationList && notificationBadge && notificationCount) {
        Echo.private('admin')
            .listen('.new-reservation', (e) => {
                console.log('📣 New Reservation Event received:', e);

                // Increment notification count
                let currentCount = parseInt(notificationCount.textContent) || 0;
                currentCount++;
                notificationCount.textContent = currentCount + ' New';

                // Update badge color
                notificationBadge.classList.remove('bg-success');
                notificationBadge.classList.add('bg-danger');

                // Construct the new notification HTML
                const newNotificationHtml = `
                    <li class="list-group-item list-group-item-action dropdown-notifications-item bg-label-primary animate__animated animate__fadeInDown" data-id="${e.id}">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar">
                                    <img src="/assets/img/avatars/1.png" alt="" class="rounded-circle" />
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 small">New Reservation 🎉</h6>
                                <small class="mb-1 d-block text-body">
                                    New reservation by <strong>${e.first_name} ${e.last_name}</strong> for table <strong>${e.table_name || 'N/A'}</strong> on <strong>${e.res_date}</strong>.
                                </small>
                                <small class="text-muted">Just now</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                <a href="javascript:void(0)" class="dropdown-notifications-read" data-id="${e.id}"><span class="badge badge-dot"></span></a>
                                <a href="javascript:void(0)" class="dropdown-notifications-archive" data-id="${e.id}"><span class="ti ti-x"></span></a>
                            </div>
                        </div>
                    </li>
                `;

                // Prepend the new notification to the list
                notificationList.insertAdjacentHTML('afterbegin', newNotificationHtml);

                // Optional: Show a toast/sweetalert notification
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    icon: 'info',
                    title: `New Reservation by ${e.first_name} ${e.last_name}`,
                    text: `Table: ${e.table_name || 'N/A'} at ${e.res_date}`,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                // Limit the number of visible notifications in the dropdown (optional)
                const maxNotificationsInDropdown = 10;
                while (notificationList.children.length > maxNotificationsInDropdown) {
                    notificationList.removeChild(notificationList.lastChild);
                }

                // If "No new notifications." message exists, remove it
                const noNotificationsMessage = notificationList.querySelector('.list-group-item p.text-center.text-muted');
                if (noNotificationsMessage) {
                    noNotificationsMessage.closest('.list-group-item').remove();
                }

            })
            .error((error) => {
                console.error('Pusher channel error:', error);
                // Handle authorization errors here, e.g., redirect to login
            });
    } else {
        console.warn('Notification elements not found in the DOM. Real-time updates will not be displayed.');
    }

    // --- Event Listeners for marking notifications as read/archived ---
    // (These would require backend routes to actually update the notification status)

    // Mark all as read
    const markAllReadBtn = document.querySelector('.dropdown-notifications-all');
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', async () => {
            try {
                const response = await axios.post('/admin/notifications/mark-all-as-read'); // Define this route
                if (response.data.success) {
                    notificationList.querySelectorAll('.dropdown-notifications-item').forEach(item => {
                        item.classList.remove('bg-label-primary');
                        const badgeDot = item.querySelector('.badge-dot');
                        if (badgeDot) badgeDot.remove();
                    });
                    notificationCount.textContent = '0 New';
                    notificationBadge.classList.remove('bg-danger');
                    notificationBadge.classList.add('bg-success');
                    // Add "No new notifications" if list becomes empty
                     if (notificationList.children.length === 0) {
                        notificationList.insertAdjacentHTML('afterbegin', '<li class="list-group-item"><p class="text-center text-muted m-0">No new notifications.</p></li>');
                    }
                }
            } catch (error) {
                console.error('Error marking all notifications as read:', error);
            }
        });
    }

    // Mark single notification as read
    notificationList.addEventListener('click', async (event) => {
        const readButton = event.target.closest('.dropdown-notifications-read');
        if (readButton) {
            const notificationItem = readButton.closest('.dropdown-notifications-item');
            const notificationId = notificationItem.dataset.id;
            try {
                const response = await axios.post(`/admin/notifications/${notificationId}/mark-as-read`); // Define this route
                if (response.data.success) {
                    notificationItem.classList.remove('bg-label-primary');
                    const badgeDot = readButton.querySelector('.badge-dot');
                    if (badgeDot) badgeDot.remove();

                    // Decrement count
                    let currentCount = parseInt(notificationCount.textContent) || 0;
                    if (currentCount > 0) {
                        currentCount--;
                        notificationCount.textContent = currentCount + ' New';
                    }
                    if (currentCount === 0) {
                         notificationBadge.classList.remove('bg-danger');
                         notificationBadge.classList.add('bg-success');
                         // Add "No new notifications" if list becomes empty
                         if (notificationList.children.length === 0) {
                            notificationList.insertAdjacentHTML('afterbegin', '<li class="list-group-item"><p class="text-center text-muted m-0">No new notifications.</p></li>');
                        }
                    }
                }
            } catch (error) {
                console.error('Error marking notification as read:', error);
            }
        }
    });

    // Archive single notification
    notificationList.addEventListener('click', async (event) => {
        const archiveButton = event.target.closest('.dropdown-notifications-archive');
        if (archiveButton) {
            const notificationItem = archiveButton.closest('.dropdown-notifications-item');
            const notificationId = notificationItem.dataset.id;
            try {
                const response = await axios.post(`/admin/notifications/${notificationId}/archive`); // Define this route
                if (response.data.success) {
                    notificationItem.remove();

                    // Decrement count if it was unread
                    if (notificationItem.classList.contains('bg-label-primary')) {
                        let currentCount = parseInt(notificationCount.textContent) || 0;
                        if (currentCount > 0) {
                            currentCount--;
                            notificationCount.textContent = currentCount + ' New';
                        }
                    }
                    if (currentCount === 0) {
                         notificationBadge.classList.remove('bg-danger');
                         notificationBadge.classList.add('bg-success');
                    }
                    // Add "No new notifications" if list becomes empty
                    if (notificationList.children.length === 0) {
                        notificationList.insertAdjacentHTML('afterbegin', '<li class="list-group-item"><p class="text-center text-muted m-0">No new notifications.</p></li>');
                    }
                }
            } catch (error) {
                console.error('Error archiving notification:', error);
            }
        }
    });


} else {
    console.error('Laravel Echo is not defined. Ensure bootstrap.js is loaded correctly and before app.js.');
}
