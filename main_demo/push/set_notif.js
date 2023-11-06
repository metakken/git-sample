if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('../sw.js').then(function(registration) {
    })
    .catch(function(error) {
        console.error('Service Worker registration failed:', error);
    });
}

function setNotif(li_id){
    Notification.requestPermission().then((permission)=> {
        if (permission === 'denied') {
            alert('Push通知が拒否されているようです。ブラウザの設定からPush通知を有効化してください');
            return false;
        } else if (permission === 'granted') {
            navigator.serviceWorker.ready.then((sw)=>{
                sw.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey:"BC1VHFZkXPFeQxUZcPFaKmB0ybdEoJDP0NtRpRQcm9r1wDs59EP6HRxkBPmTqM5-I7YqPvuXh5WA2qVVozLsw4k"
                }).then((subscription)=>{
                    fetch('../push/regist_notif.php', {
                        method: 'POST',
                        body: JSON.stringify(subscription)
                    })
                });
            });
            if(li_id != 0){
                fetch('../push/regist_notif.php', {
                    method: 'POST',
                    body: li_id
                })
                .then(response => response.text())
                .then(data =>{
                    if(data === "false"){
                        alert("通知設定に失敗しました。")
                    }
                    else{
                        if(data != "true"){
                            alert(data);
                        }
                        var button = document.getElementById('bell'+li_id);
                        var img = button.querySelector("img");
                        
                        if (img.src.endsWith('pushed_bell.png')) {
                            img.src = '../image/bell.png';
                            button.style.backgroundColor = '#ffffff';
                        }
                        else {
                            img.src = '../image/pushed_bell.png';
                            button.style.backgroundColor = '#3aabd2';
                        }
                    }
                });
            }
        }
    })
}

function sendPush(){
    fetch('send_push.php', {
        method: 'POST',
    })
    .then(response => response.text())
    .then(data => {
        if(data != "true"){
            alert("通知失敗："+data)
        }
    });
}