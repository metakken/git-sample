<?php
session_start();

// データベースに接続
require_once('../connectDB.php');
$pdo = connectDB();

$sql = 'SELECT * FROM request';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$request = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>LICENSE SQUARE：管理者ページ</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../main.css?<?php echo date('Ymd-Hi'); ?>">
        <link rel="stylesheet" href="admin_main.css?<?php echo date('Ymd-Hi'); ?>">
        <script type="text/javascript" src="admin_main.js?<?php echo date('Ymd-Hi'); ?>"></script>
    </head>

    <body>
        <div class="header">
            <div>LICENSE SQUARE：リクエスト一覧</div>
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
                    <div class="all_license">総数：</div>
                    <div><?=count($request)?>件</div>
                </div>
                
                <?php for ($i = 0; $i < count($request); $i++): ?>
                    <div class="request_data">
                        <div>
                            <div class="req_c"><?=$request[$i]['request_c']?></div>
                            <div class="req_url"><?=$request[$i]['request_url']?></div>
                        </div>
                        <button class="garbage" onclick="deleteRequest(<?=$request[$i]['request_id']?>)"><img src="../image/garbage.png"/></button>
                    </div>
                <?php endfor; ?>
                </div>
            </div>
        </div>
    </body>
</html>