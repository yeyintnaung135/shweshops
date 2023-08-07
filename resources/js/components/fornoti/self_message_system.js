import Echo from 'laravel-echo';
import app from '../../app.js'
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    wsHost: window.location.host,
    wssPort: 6001,
    wsPort: 6001,
    forceTLS: true,
    forceTLS: false,
    encrypted: false,
    enabledTransports: ['ws', 'wss'],

});



window.Echo.channel("yankee-channel")
    .listen('.yankee-event', (e) => {
        app.chatdata.push(e.chatdata)
        console.log(Notification.permission)
        showbrowsernoti();
        app.notimessage='xxxx';
        console.log(e);
});

const showbrowsernoti=()=>{
    new Notification('title')

}
