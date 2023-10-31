<script>
<?php
    session_start();
    $_SESSION['user_id'] = 1;

// フォーム送信以外のHTTPリクエストが行われたとき
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // データベースに接続
    require_once('../connectDB.php');
    $pdo = connectDB();
    // 全資格テーブルから資格名が一致する行を取得(:li_nameは後で定義)
    $sql = 'SELECT * FROM license WHERE li_name = :li_name LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':li_name', $_POST['license'], PDO::PARAM_STR);    // sqlコマンド中にそのまま値を書くよりこうやってあとで定義した方が良い
    $stmt->execute();
    $license = $stmt->fetch();  // 一行取得

    if(!$license){
        echo "alert('この資格は現在対応しておりません。リクエストから追加申請をお願いいたします。');";
    }
    else{
        // 保有資格テーブルに既に登録されているかを確認
        $sql = 'SELECT * FROM p_license WHERE user_id = :user AND license_id = :license';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user',$_SESSION['user_id'],PDO::PARAM_INT);
        $stmt->bindValue(':license',$license['li_id'],PDO::PARAM_INT);
        $stmt->execute();
        $exist = $stmt->fetch();
        if(!$exist){    // 登録されていなかった場合
            $user_id = $_SESSION['user_id'];
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
            $sql = 'INSERT INTO p_license (user_id, license_id, aqs_date, image_type, image_file, image_size, expiry_date, next_date) VALUES (:user_id, :license_id, :aqs_date, :image_type, :image_file, :image_size, :expiry_date, :next_date)';
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
            header('Location:../main/main.php');  // ページを更新
            exit();
        }
        else{   // 登録済みの場合
            echo "alert('この資格は既に登録されています');";
        }
    }
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
        <link rel="stylesheet" href="regist.css?<?php echo date('Ymd-Hi'); ?>">
        <script type="text/javascript" src="image_form.js?<?php echo date('Ymd-Hi'); ?>"></script>
    </head>

    <body>
        <div class="header">
            <div>LICENSE SQUARE : 保有資格登録</div>
            <div class="header_icon">
                <a href="#" class="gear"><img src="../image/gear.png"/></a>
                <a href="#" class="account"><img src="../image/account.png"/></a>
            </div>
        </div>

        <div class="container">
            <div id="menu">
                <ul>
                    <li><a href="../main/main.php">保有資格</a></li>
                    <li><a href="#">関連資格</a></li>
                    <li><a href="#">資格一覧</a></li>
                    <li><a href="#">資格診断</a></li>
                </ul>
            </div>
    
            <div class="main">
                <form method="post" enctype="multipart/form-data" style="max-width: 48%;">
                    <p><label for="license" class="required">資格名</label></p>
                    <input list="all_license" name="license" id="license" required>
                    <datalist id="all_license">
                        <?php
                            require_once '../connectDB.php';
                            $pdo = connectDB();
                            $sql = 'SELECT li_name FROM license';
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();
                            $license = $stmt->fetchAll();
                            for ($i = 0; $i < count($license); $i++){
                                echo '<option value='.$license[$i]["li_name"].'>';
                            }
                        ?>
                    </datalist>
                    </select></br>
                    <p><label for="date" class="required">取得年月日</label></p>
                    <input type="date" name="date" id="date" max="<?=date('Y-m-d');?>" required></br>
                    <p><label for="image">資格証明書等画像</label></p>
                    <input type="file" name="image" id="image" onchange="showImage(this)">
                    <p><button type="submit">登録</button></p>
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