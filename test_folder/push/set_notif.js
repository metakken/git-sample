if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('sw.js').then(function(registration) {
        console.log('Service Worker registered with scope:', registration.scope);
    })
    .catch(function(error) {
        console.error('Service Worker registration failed:', error);
    });
}

function enableNotif(){
    Notification.requestPermission().then((permission)=> {
        if (permission === 'denied') {
            alert('Push通知が拒否されているようです。ブラウザの設定からPush通知を有効化してください');
            return false;
        } else if (permission === 'granted') {
            // alert('すでにWebPushを許可済みです');
            navigator.serviceWorker.ready.then((sw)=>{
                sw.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey:"BC1VHFZkXPFeQxUZcPFaKmB0ybdEoJDP0NtRpRQcm9r1wDs59EP6HRxkBPmTqM5-I7YqPvuXh5WA2qVVozLsw4k"
                }).then((subscription)=>{
                    sessionStorage.subscription = JSON.stringify(subscription);
                });
            });
        }
    })
}

function sendPush(){
    fetch('send_test.php', {
        method: 'POST',
        body : sessionStorage.subscription,
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.text())
    .then(data => {
        if(data === "false"){
            alert('"Enable Notif"をクリックしてください。')
        }
    });
}