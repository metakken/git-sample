<?php
// データベースに接続
require_once('connectDB.php');
$pdo = connectDB();

// フォーム送信以外のHTTPリクエストが行われたとき
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // 保有資格テーブルからデータをすべて取得
    $sql = 'SELECT * FROM p_license ORDER BY user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $p_license = $stmt->fetchAll(); // 全行取得
// フォーム送信が行われたとき
} else {
    // 全資格テーブルから資格名が一致する行を取得(:li_nameは後で定義)
    $sql = 'SELECT * FROM license WHERE li_name = :li_name LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':li_name', $_POST['license'], PDO::PARAM_STR);    // sqlコマンド中にそのまま値を書くよりこうやってあとで定義した方が良い
    $stmt->execute();
    $license = $stmt->fetch();  // 一行取得

    // 保有資格テーブルに既に登録されているかを確認
    $sql = 'SELECT * FROM p_license WHERE user_id = :user AND license_id = :license';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user',$_POST['user'],PDO::PARAM_INT);
    $stmt->bindValue(':license',$license['li_id'],PDO::PARAM_INT);
    $stmt->execute();
    $exist = $stmt->fetch();
    if(!$exist){    // 登録されていなかった場合
        $user_id = $_POST['user'];  // フォームから取得したidを代入
        $license_id = $license['li_id'];    // データベースから取得した資格idを代入
        $aqs_date = $_POST['date']; // フォームから取得した日付を代入
        $type = NULL;
        $file = NULL;
        $size = NULL;
        $expiry_date = NULL;
        $next_date = NULL;
        if (!empty($_FILES['image']['name'])) { // 画像が選択されている場合色々代入
            $type = $_FILES['image']['type'];
            $file = file_get_contents($_FILES['image']['tmp_name']);
            $size = $_FILES['image']['size'];
        }
        if ($license['update_flag']){   // 更新が必要な資格の場合
            $expiry_date = new DateTime($_POST['date']);
            $expiry_date->modify($license['valid_period']); // 取得年月日に有効期間を加算
            $next_date = clone $expiry_date;
            $next_date->modify('-1years');  // 有効期間の一年前に通知日時を設定
            $expiry_date=$expiry_date->format('Y-m-d'); // 文字列に変換
            $next_date=$next_date->format('Y-m-d'); // 文字列に変換
        }

        // 保有資格テーブルにデータを挿入
        $sql = 'INSERT INTO p_license VALUES (:user_id, :license_id, :aqs_date, :image_type, :image_file, :image_size, :expiry_date, :next_date)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':license_id', $license_id, PDO::PARAM_INT);
        $stmt->bindValue(':aqs_date', $aqs_date, PDO::PARAM_STR);
        $stmt->bindValue(':image_type', $type, PDO::PARAM_STR);
        $stmt->bindValue(':image_file', $file, PDO::PARAM_STR);
        $stmt->bindValue(':image_size', $size, PDO::PARAM_INT);
        $stmt->bindValue(':expiry_date', $expiry_date, PDO::PARAM_STR);
        $stmt->bindValue(':next_date', $next_date, PDO::PARAM_STR);
        $stmt->execute();
        header('Location:li_maneger.php');  // ページを更新
        exit();
    }
    else{   // 登録済みの場合
        echo "この資格は既に登録されています";
        // 保有資格テーブルから資格を全て取得する処理を行わないと資格表示ができない
        $sql = 'SELECT * FROM p_license ORDER BY user_id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $p_license = $stmt->fetchAll();
    }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>License Manegement</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
    <!-- 入力フォーム -->
    <form method="post" enctype="multipart/form-data" style="max-width: 48%;">
        <label for="user">ユーザを選択:</label>
        <select name="user">
            <option value=1>田中</option>
            <option value=2>佐藤</option>
        </select>
        <label for="license">資格を選択:</label>
        <select name="license">
            <option>草むしり検定</option>
            <option>うさぎ跳び2級</option>
            <option>ITパスポート</option>
        </select></br>
        <label for="date">取得年月日:</label>
        <input type="date" name="date" max="<?=date('Y-m-d');?>" required></br>
        <label for="image">画像を選択:</label>
        <input type="file" name="image" id="image">
        <button type="submit">登録</button>
    </form>
    <!-- 保有資格表示 -->
    <?php for ($i = 0; $i < count($p_license); $i++): ?>
        <div class="license">
            <?php
            // 保有資格テーブルから取得したユーザIDと資格IDを使って、ユーザの姓と資格名を取得
            require_once('p_license.php');
            [$lastname, $li_name] = p_license($p_license[$i]['user_id'],$p_license[$i]['license_id']);
            ?>
            <p>ユーザ名：<?=$lastname?>　　資格名：<?=$li_name?>　　取得年月日：<?=$p_license[$i]['aqs_date']?></p>
            <?php 
            // 有効期限が存在するとき
            if ($p_license[$i]['expiry_date']){
                echo "<p>有効期限：{$p_license[$i]['expiry_date']}　　次回通知日時：{$p_license[$i]['next_date']}</p>";
            }
            else{
                echo '<p>有効期限： ―　　次回通知日時：  ―</p>';
            }
            // 画像が存在するとき
            if ($p_license[$i]['image_type']){
                // 色々やって
                $base64Image = base64_encode($p_license[$i]['image_file']);
                $imageType = $p_license[$i]['image_type'];
                // HTMLコードを出力
                echo "<img src='data:{$imageType};base64,{$base64Image}' alt='image " . ($i + 1) . "' class='custom-image'>";
            }
            ?>
            <!-- 削除ボタンが押されると削除処理が実行 -->
            <a href='delete.php?user=<?= $p_license[$i]['user_id']?>&license=<?= $p_license[$i]['license_id']?>'>削除</a>
        </br></br>
        </div>
    <?php endfor; ?>
</div>
</body>
</html>
