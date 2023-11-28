<script>
<?php
session_start();

// データベースに接続
require_once('../connectDB.php');
$pdo = connectDB();

// フォームが送信された場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // テキストボックスの値を取得
    $request_c = isset($_POST['request_c']) ? $_POST['request_c'] : '';
    $request_url = isset($_POST['request_url']) ? $_POST['request_url'] : '';

    // データベースに挿入
    $sql = 'INSERT INTO request (request_c, request_url) VALUES (:request_c, :request_url)';
    $stmt=$pdo->prepare($sql);
    $stmt->bindValue(':request_c', $request_c, PDO::PARAM_STR);
    $stmt->bindValue(':request_url', $request_url, PDO::PARAM_STR);
    $stmt->execute();
    echo "alert('リクエストが送信されました');";
}
?>
</script>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>LICENSE SQUARE</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../main.css?<?php echo date('Ymd-Hi'); ?>">
        <link rel="stylesheet" href="../regist_license/regist.css?<?php echo date('Ymd-Hi'); ?>">
        <link rel="stylesheet" href="../admin_main/admin_main.css?<?php echo date('Ymd-Hi'); ?>">
        <script type="text/javascript" src="main.js?<?php echo date('Ymd-Hi'); ?>"></script>

    <body>
        <div class="header">
            <div>LICENSE SQUARE：リクエスト送信</div>
            <div class="header_icon">
                <a href="#" class="gear"><img src="../image/gear.png"/></a>
                <a href="../mainmenu/account_menu.php" class="account"><img src="../image/account.png"/></a>
            </div>
        </div>

        <div class="container">
            <div id="menu">
                <ul>
                    <li><a href="../main/main.php">保有資格</a></li>
                    <li><a href="../mainmenu/relative_licenses_main.php">関連資格</a></li>
                    <li><a href="../mainmenu/all_license_main.php">資格一覧</a></li>
                    <li><a href="../main/license_shi.php">資格診断</a></li>
                    <li><a href="../mainmenu/group_checker.php">グループ</a></li>
                    <li><a href="../main/request.php">リクエスト送信</a></li>
                </ul>
            </div>
    
            <div class="main">
                <form method="post">
                    <p><label for="exp" class="required">リクエスト内容</label></p>
                    <textarea name="request_c" id="exp" required></textarea>
                    <p><label for="exp">リクエスト資格URL</label></p>
                    <textarea name="request_url" id="exp" required></textarea>
                    <p><button type="submit" id="edit_button">送信</button></p>
                </form>
            </div>
        </div>
    </body>
</html>