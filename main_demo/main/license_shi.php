<?php
session_start();
require_once('../connectDB.php');

$pdo=connectDB();
$license = [];
// フォームが送信された場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // データベースから結果を取得
    $sql ='SELECT * FROM license WHERE li_division = :li_division AND li_field = :li_field AND li_direction = :li_direction';
    $stmt=$pdo->prepare($sql);
    $stmt->bindValue(':li_division', $_POST['li_division'], PDO::PARAM_STR);
    $stmt->bindValue(':li_field', $_POST['li_field'], PDO::PARAM_STR);
    $stmt->bindValue(':li_direction', $_POST['li_direction'], PDO::PARAM_STR);
    $stmt->execute();
    $license = $stmt->fetchAll();
}

?>


<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>LICENSE SQUARE</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../main.css?<?php echo date('Ymd-Hi'); ?>">
        <link rel="stylesheet" href="../admin_main/admin_main.css?<?php echo date('Ymd-Hi'); ?>">
        <link rel="stylesheet" href="license_shi.css?<?php echo date('Ymd-Hi'); ?>">
        <script type="text/javascript" src="../main/main.js?<?php echo date('Ymd-Hi'); ?>"></script>

    <body>
        <div class="header">
            <div>LICENSE SQUARE：資格診断</div>
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
                    <h3>資格区分</label></h3>
                    <label>
                        国家資格:
                        <input type="radio" name="li_division" value="国家資格" required> 
                    </label>
                    <br>
                    <label>
                        国際資格:
                        <input type="radio" name="li_division" value="国際資格">
                    </label>
                    <br>
                    <label>
                        民間資格:
                        <input type="radio" name="li_division" value="民間資格">
                    </label>
                    <hr>

                    <h3>資格分野</label></h3>
                    <label>
                        情報系:
                        <input type="radio" name="li_field" value="情報系" required> 
                    </label>
                    <br>
                    <label>
                        言語系:
                        <input type="radio" name="li_field" value="言語系"> 
                    </label>
                    <br>
                    <label>
                        その他:
                        <input type="radio" name="li_field" value="その他">
                    </label>
                    <hr>

                    <h3>資格指向性</label></h3>
                    <label>
                        個人:
                        <input type="radio" name="li_direction" value="1" required> 
                    </label>
                    <br>
                    <label>
                        集団:
                        <input type="radio" name="li_direction" value="2"> 
                    </label>
                    <br>

                    <p><input id="shi" type="submit" value="診断"></p>
                </form>
                <?php
                    if(count($license)==0){
                        echo '<div class="vertical_line" style="display:none"></div>';
                    }
                    else{
                        echo '<div class="vertical_line"></div>';
                    }
                ?>
                <div class="right">
                    <?php if(count($license)>0):?>
                    <label>あなたにおすすめの資格</label>
                    <div class="license_column">
                        <div class="all_li_name">資格名</div>
                        <div class="all_li_div">資格区分</div>
                        <div class="all_li_fi">資格分野</div>
                    </div>
                    <?php endif ?>
                    <?php for ($i = 0; $i < count($license); $i++): ?>
                        <div class="all_license_data">
                            <div class="li_name"><?=$license[$i]['li_name']?></div>
                            <div class="li_div"><?=$license[$i]['li_division']?></div>
                            <div class="li_fi"><?=$license[$i]['li_field']?></div>
                            <button class="detail" onclick="showAllDetail(<?=$license[$i]['li_id']?>)"><img src="../image/detail.png"/></button>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </body>
</html>