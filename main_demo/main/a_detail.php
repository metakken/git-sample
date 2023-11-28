<?php
    session_start();
    // データベースに接続
    require_once('../connectDB.php');
    $pdo = connectDB();

    // 該当資格の資格データを取得
    $sql = 'SELECT * FROM license WHERE li_id = :license_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':license_id', (int)$_GET['license'], PDO::PARAM_INT);
    $stmt->execute();
    $license = $stmt->fetch();

    if($license["superior_id"]){
        $sql = 'SELECT * FROM license WHERE li_id = :license_id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':license_id', $license["superior_id"], PDO::PARAM_INT);
        $stmt->execute();
        $superior_license = $stmt->fetch();
        $superior = $superior_license['li_name'];
    }
    else{
        $superior = "";
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
    </head>

    <body>
        <div class="header">
            <div>LICENSE SQUARE : 資格詳細</div>
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
                <div class="main_function">
                    <div class="license_name"><div class="center">資格名：</div><div class="margin_r"><?=$license['li_name']?></div></div>  
                </div>
                <div>
                    <div class="license_detail"><div class="center">更新フラグ：</div><div class="margin_r"><?=$license['update_flag']?></div></div>  
                    <div class="license_detail"><div class="center">有効期間：</div><div class="margin_r"><?=$license['valid_period']?></div></div> 
                    <div class="license_detail"><div class="center">資格区分：</div><div class="margin_r"><?=$license['li_division']?></div></div>  
                    <div class="license_detail"><div class="center">資格分野：</div><div class="margin_r"><?=$license['li_field']?></div></div>
                    <div class="license_detail"><div class="center">発行機関：</div><div class="margin_r"><?=$license['li_authority']?></div></div>  
                    <div class="license_detail"><div class="center">説明：</div><div class="margin_r"><?=$license['explanation']?></div></div>  
                    <div class="license_detail"><div class="center">サイトURL：</div><div class="margin_r"><?=$license['site_url']?></div></div>
                    <?php
                        if ($license['superior_id']){
                            echo '<div class="license_detail2"><div class="center">上位資格：</div><div class="margin_r">'.$superior.'</div><div class="license_data2">';
                            echo "<button id='detail' onclick='showAllDetail({$license['superior_id']})'><img src='../image/detail.png'/></button>";
                            echo '</div></div>';
                        }
                    ?>
                    </div></div>  
                </div>
            </div>
        </div>
    </body>
</html>