import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});

const userId = document.querySelector('meta[name="user-id"]').content; // add meta in your blade

Echo.private('user.' + userId)
    .listen('MessageSent', (e) => {
        showAlert(e);
        appendMessageToChat(e);
    });

function showAlert(e) {
    const container = document.getElementById('alerts');
    if(!container) return;
    const alert = document.createElement('div');
    alert.classList.add('alert', 'alert-info');
    alert.innerText = `New message from user ${e.sender_id}: ${e.content}`;
    container.appendChild(alert);
    setTimeout(() => alert.remove(), 5000);
}

// Optional: append message in chat
function appendMessageToChat(e) {
    const chat = document.getElementById('chat-messages');
    if(!chat) return;
    const msg = document.createElement('div');
    msg.classList.add('chat-message');
    msg.innerText = `${e.sender_id}: ${e.content}`;
    chat.appendChild(msg);
}
