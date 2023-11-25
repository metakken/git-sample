<?php
session_start();
$_SESSION['user_id'] = 1;

// データベースに接続
require_once('../connectDB.php');
$pdo = connectDB();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['searcher'])) {   // 資格検索時
    $sql = 'SELECT * FROM license WHERE li_name LIKE :li_name';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':li_name', '%'.$_POST['searcher'].'%', PDO::PARAM_STR);
    $stmt->execute();
    $license = $stmt->fetchAll();

    $tmp = [];
    foreach ($license as $item) {
        $tmp[] = 'license_id = '.$item['li_id'];
    }

    $sql = 'SELECT * FROM p_license WHERE user_id = :user_id AND ('.implode(' OR ', $tmp).')';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
    $stmt->execute();
    $p_license = $stmt->fetchAll();
}
else {
    // 保有資格テーブルからデータをすべて取得
    $sql = 'SELECT * FROM p_license WHERE user_id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
    $stmt->execute();
    $p_license = $stmt->fetchAll(); // 全行取得
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>LICENSE SQUARE</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../main.css?<?php echo date('Ymd-Hi'); ?>">
        <script type="text/javascript" src="main.js?<?php echo date('Ymd-Hi'); ?>"></script>
        <script type="text/javascript" src="../push/set_notif.js?<?php echo date('Ymd-Hi'); ?>"></script>
    </head>

    <body>
        <div class="header">
            <div>LICENSE SQUARE</div>
            <div class="header_icon">
                <a href="#" class="gear"><img src="../image/gear.png"/></a>
                <a href="#" class="account"><img src="../image/account.png"/></a>
            </div>
        </div>

        <div class="container">
            <div id="menu">
                <ul>
                    <li><a href="main.php">保有資格</a></li>
                    <li><a href="#">関連資格</a></li>
                    <li><a href="#">資格一覧</a></li>
                    <li><a href="#">資格診断</a></li>
                </ul>
            </div>
    
            <div class="main">
                <div class="main_function">
                    <div class="all_license">総数：</div>
                    <div><?=count($p_license)?></div>

                    <form method="post" class="search-box">
                        <input type="text" placeholder="資格名を入力" name="searcher">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>

                    <button id="add" onclick="addLicense()">+Add</button>        
                </div>
                
                <!-- 保有資格表示 -->
                <?php for ($i = 0; $i < count($p_license); $i++): ?>                
                    <div class="license_data">
                        <?php
                            require_once '../connectDB.php';
                            $pdo = connectDB();
                            // 資格名を取得
                            $sql = 'SELECT * FROM license WHERE li_id = :li_id LIMIT 1';
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindValue(':li_id', $p_license[$i]['license_id'], PDO::PARAM_INT);
                            $stmt->execute();
                            $license = $stmt->fetch();
                        ?>
                        <div>
                            <div class="license_name"><?=$license['li_name']?></div>
                            <?php 
                            // 有効期限が存在するとき
                            if ($p_license[$i]['expiry_date']){
                                echo "<div class='deadline'>有効期限：{$p_license[$i]['expiry_date']}</div>";
                            }
                            else{
                                echo '<div class="deadline">有効期限：　　―</div>';
                            }
                            ?>
                        </div>
                        <?php
                            if ($license['update_flag'] && new DateTime() <= new DateTime($p_license[$i]['expiry_date'])){
                                if($p_license[$i]['next_date']){
                                    echo "<button class='pushed_bell' id='bell{$p_license[$i]['license_id']}' onclick='setNotif({$p_license[$i]['license_id']})'><img src='../image/pushed_bell.png'/></button>";
                                }else{
                                    echo "<button class='bell' id='bell{$p_license[$i]['license_id']}' onclick='setNotif({$p_license[$i]['license_id']})'><img src='../image/bell.png'/></button>";
                                }
                            }
                            else{
                                echo "<button class='disnabled_bell'><img src='../image/bell.png'/></button>";
                            }
                        ?>
                        <button class="garbage" onclick="removeLicense(<?= $p_license[$i]['license_id']?>)"><img src="../image/garbage.png"/></button>
                        <button class="detail" onclick="showDetail(<?=$p_license[$i]['license_id']?>)"><img src="../image/detail.png"/></button>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </body>
</html>