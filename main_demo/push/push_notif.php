<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>LICENSE SQUARE：管理者ページ</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../main.css?<?php echo date('Ymd-Hi'); ?>">
        <link rel="stylesheet" href="push.css?<?php echo date('Ymd-Hi'); ?>">
        <script type="text/javascript" src="../push/set_notif.js?<?php echo date('Ymd-Hi'); ?>"></script>
    </head>

    <body>
        <div class="header">
            <div>LICENSE SQUARE：通知一斉送信</div>
            <div class="header_icon">
                <a href="#" class="gear"><img src="../image/gear.png"/></a>
                <a href="#" class="account"><img src="../image/account.png"/></a>
            </div>
        </div>

        <div class="container">
            <div id="menu">
                <ul>
                    <li><a href="../admin_main/admin_main.php">資格追加・編集</a></li>
                    <li><a href="../admin_main/request.php">リクエスト一覧</a></li>
                    <li><a href="../push/push_notif.php">通知一斉送信</a></li>
                </ul>
            </div>
    
            <div class="main">
                <div class="main_function">
                    <label for="send_push">更新期限一斉通知</label>
                    <p><button id="send_push" type="submit" onclick="sendPush()">送信</button></p>
                </div>
            </div>
        </div>
    </body>
</html>