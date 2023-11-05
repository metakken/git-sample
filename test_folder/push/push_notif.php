<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Push Notif</title>
    </head>
    <body>
        <h1>Javascript & PHP push notif demo</h1>
        <script type="text/javascript" src="set_notif.js?<?php echo date('Ymd-Hi'); ?>"></script>
        <button onclick="enableNotif()">Enable Notif</button>
        <button onclick="sendPush()">Send Push</button>
    </body>
</html>