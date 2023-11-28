<script>
<?php
session_start();
require_once('../connectDB.php');
$pdo = connectDB();

// 該当資格の保有資格データを取得
$sql = 'SELECT * FROM p_license WHERE user_id = :user_id AND license_id = :license_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
$stmt->bindValue(':license_id', (int)$_GET['license'], PDO::PARAM_INT);
$stmt->execute();
$p_license = $stmt->fetch();

// 該当資格の資格データを取得
$sql = 'SELECT * FROM license WHERE li_id = :license_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':license_id', (int)$_GET['license'], PDO::PARAM_INT);
$stmt->execute();
$license = $stmt->fetch();

// フォーム送信のHTTPリクエストが行われたとき
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $license_id = $license['li_id'];    // データベースから取得した資格idを代入
    $aqs_date = $_POST['date']; // フォームから取得した日付を代入
    $expiry_date = NULL;
    $next_date = NULL;
    if (!empty($_FILES['image']['name'])) { // 画像が選択されている場合色々代入
        $type = $_FILES['image']['type'];
        $file = file_get_contents($_FILES['image']['tmp_name']);
        $size = $_FILES['image']['size'];
        $sql = 'UPDATE p_license SET image_type=:image_type, image_file=:image_file, image_size=:image_size WHERE user_id = :user_id AND license_id = :license_id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
        $stmt->bindValue(':license_id', (int)$_GET['license'], PDO::PARAM_INT);
        $stmt->bindValue(':image_type', $type, PDO::PARAM_STR);
        $stmt->bindValue(':image_file', $file, PDO::PARAM_STR);
        $stmt->bindValue(':image_size', $size, PDO::PARAM_INT);
        $stmt->execute();
    }
    if ($license['update_flag']){   // 更新が必要な資格の場合
        $expiry_date = new DateTime($_POST['date']);
        $expiry_date->modify($license['valid_period']); // 取得年月日に有効期間を加算
        $next_date = clone $expiry_date;
        $next_date->modify('-1years');  // 有効期間の一年前に通知日時を設定
        if($next_date < new DateTime()){
            $next_date = clone $expiry_date;
            $next_date->modify('-1 month');
        }
        $expiry_date=$expiry_date->format('Y-m-d'); // 文字列に変換
        $next_date=$next_date->format('Y-m-d'); // 文字列に変換
    }

    $sql = 'UPDATE p_license SET aqs_date=:aqs_date, expiry_date=:expiry_date, next_date=:next_date WHERE user_id = :user_id AND license_id = :license_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
    $stmt->bindValue(':license_id', (int)$_GET['license'], PDO::PARAM_INT);
    $stmt->bindValue(':aqs_date', $aqs_date, PDO::PARAM_STR);
    $stmt->bindValue(':expiry_date', $expiry_date, PDO::PARAM_STR);
    $stmt->bindValue(':next_date', $next_date, PDO::PARAM_STR);
    $stmt->execute();
    header('Location:../main/l_detail.php?license='.(int)$_GET['license']);
    exit();
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
        <script type="text/javascript" src="../regist_license/image_form.js?<?php echo date('Ymd-Hi'); ?>"></script>
    </head>

    <body>
        <div class="header">
            <div>LICENSE SQUARE : 保有資格更新</div>
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
                <form method="post" enctype="multipart/form-data" style="max-width: 48%;">
                    <label for="license">資格名：<?=$license['li_name']?></label></br>
                    <p><label for="date" class="required">更新年月日</label></p>
                    <input type="date" name="date" id="date" max="<?=date('Y-m-d');?>" value="<?=$p_license['aqs_date']?>" required></br>
                    <p><label for="image">資格証明書等画像(既に登録済みの場合は上書きされます)</label></p>
                    <input type="file" name="image" id="image" onchange="showImage(this)">
                    <p><button type="submit">更新</button></p>
                </form>
                <div class="vertical_line" style="display:none"></div>
                <div class="right">
                    <div id="image_container"></div>
                    <button type="button" id="cancel_image" onclick="cancelImage()" style="display:none">キャンセル</button>
                </div>
            </div>
        </div>
    </body>
</html>