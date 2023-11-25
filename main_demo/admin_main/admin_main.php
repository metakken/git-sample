<?php
session_start();
$_SESSION['user_id'] = "admin";

// データベースに接続
require_once('../connectDB.php');
$pdo = connectDB();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['searcher'])) {   // 資格検索時
    $sql = 'SELECT * FROM license WHERE li_name LIKE :li_name';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':li_name', '%'.$_POST['searcher'].'%', PDO::PARAM_STR);
    $stmt->execute();
    $license = $stmt->fetchAll();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ファイルが正しくアップロードされたか確認
    if (isset($_FILES["csv"]) && $_FILES["csv"]["error"] == 0) {
        // アップロードされたファイルの情報取得
        $tmpName = $_FILES["csv"]["tmp_name"];
        $type = $_FILES["csv"]["type"];

        // ファイルがCSV形式か確認
        if ($type == "text/csv" || $type == "application/vnd.ms-excel") {
            // CSVファイルを読み込み、データベースに挿入
            $file = fopen($tmpName, "rw");
            fgetcsv($file);
            while (($data = fgetcsv($file, 0, ",")) !== FALSE) {
                $sup_id = NULL;
                $sql = 'SELECT * FROM license WHERE li_name = :li_name';
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':li_name', $data[10], PDO::PARAM_STR);
                $stmt->execute();
                $super = $stmt->fetch();
                if($super){
                    $sup_id = $super["li_id"];
                }
        
                if($super || !$_POST['super']){
                    $sql = 'INSERT INTO license (li_name, update_flag, valid_period, li_division, li_field, li_authority, pass_rate, li_direction, explanation, site_url, superior_id, update_term1, update_term2, update_site)
                    VALUES (:li_name, :update_flag, :valid_period, :li_div, :li_fi, :li_auth, :pass_rate, :li_dir, :exp, :site_url, :sup_id, :term1, :term2, :update_site)';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':li_name', $data[0], PDO::PARAM_STR);
                    $stmt->bindValue(':update_flag', $data[1], PDO::PARAM_INT);
                    $stmt->bindValue(':valid_period', $data[2], PDO::PARAM_STR);
                    $stmt->bindValue(':li_div', $data[3], PDO::PARAM_STR);
                    $stmt->bindValue(':li_fi', $data[4], PDO::PARAM_STR);
                    $stmt->bindValue(':li_auth', $data[5], PDO::PARAM_STR);
                    $stmt->bindValue(':pass_rate', isset($data[6]) ? $data[6] : NULL, PDO::PARAM_NULL);
                    $stmt->bindValue(':li_dir', isset($data[7]) ? $data[7] : NULL, PDO::PARAM_NULL);
                    $stmt->bindValue(':exp', ($data[8]!=="") ? $data[8] : NULL);
                    $stmt->bindValue(':site_url', ($data[9]!=="") ? $data[9] : NULL);
                    $stmt->bindValue(':sup_id', $sup_id, PDO::PARAM_INT);
                    $stmt->bindValue(':term1', ($data[11]!=="") ? $data[11] : NULL);
                    $stmt->bindValue(':term2', ($data[12]!=="") ? $data[12] : NULL);
                    $stmt->bindValue(':update_site', ($data[13]!=="") ? $data[13] : NULL);
                    if(!($stmt->execute())){
                        continue;
                    }
                }
            }
            fclose($file);
            header('Location:../admin_main/admin_main.php');
            exit();
        } else {
            echo "alert('CSVファイルを入力してください。');";
        }
    } else {
        echo "alert('ファイルのアップロードに失敗しました。');";
    }
}
else {
    $sql = 'SELECT * FROM license';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $license = $stmt->fetchAll();
}
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
            <div>LICENSE SQUARE：資格追加・編集</div>
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
                    <div><?=count($license)?></div>

                    <form method="post" class="search-box">
                        <input type="text" placeholder="資格名を入力" name="searcher">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>

                    <form method="post" enctype="multipart/form-data" class="csv">
                        <label for="csv" id="csv_label">データをCSV UTF-8形式でインポート：</label>
                        <input type="file" name="csv" id="csv" accept=".csv" required>
                        <button id="add" onclick="">+Add</button>
                    </form>
                </div>

                <div class="license_column">
                    <div class="li_id">資格ID</div>
                    <div class="li_name">資格名</div>
                    <div class="valid_period">有効期間</div>
                    <div class="li_div">資格区分</div>
                    <div class="li_fi">資格分野</div>
                    <div class="li_auth">発行機関</div>
                </div>
                
                <?php for ($i = 0; $i < count($license); $i++): ?>
                    <div class="all_license_data">
                        <?php
                        if(strlen($license[$i]['li_id']) == 1){
                            echo "<div class='li_id'>00{$license[$i]['li_id']}</div>";
                        }
                        else if(strlen($license[$i]['li_id']) == 2){
                            echo "<div class='li_id'>0{$license[$i]['li_id']}</div>";
                        }
                        else{
                            echo "<div class='li_id'>0{$license[$i]['li_id']}</div>";
                        }
                        ?>
                        <div class="li_name"><?=$license[$i]['li_name']?></div>
                        <div class="valid_period"><?=$license[$i]['valid_period']?></div>
                        <div class="li_div"><?=$license[$i]['li_division']?></div>
                        <div class="li_fi"><?=$license[$i]['li_field']?></div>
                        <div class="li_auth"><?=$license[$i]['li_authority']?></div>
                        <button class="detail" onclick="showDetail(<?=$license[$i]['li_id']?>)"><img src="../image/detail.png"/></button>
                    </div>
                <?php endfor; ?>
                </div>
            </div>
        </div>
    </body>
</html>