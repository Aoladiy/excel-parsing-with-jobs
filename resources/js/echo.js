import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

function newRow(id, name, date) {
    const newRowEvent = new CustomEvent('newRowAdded', { detail: { id, name, date } });
    window.dispatchEvent(newRowEvent);
}
window.Echo.channel('rows')
    .listen('RowCreated', (event) => {
        newRow(event.id, event.name, event.date);
    });
