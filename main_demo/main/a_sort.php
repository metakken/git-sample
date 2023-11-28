<?php
session_start();
// データベースに接続
require_once('../connectDB.php');
$pdo = connectDB();

if ($_SERVER['REQUEST_METHOD']) {
    if(isset($_POST["sort"])) {
        // セレクトボックスで選択された値を受け取る
        $sort_info = $_POST["sort"];
      
        if($sort_info=='option1'){
            $sql = 'SELECT * FROM license ORDER BY li_name';
        }else if($sort_info=='option2'){
            $sql = 'SELECT * FROM license ORDER BY valid_period';
        }else if($sort_info=='option3'){
            $sql = 'SELECT * FROM license ORDER BY li_field';
        }
      }

    // 該当資格の資格データを取得
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $license = $stmt->fetchALL();
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
        <script type="text/javascript" src="main.js?<?php echo date('Ymd-Hi'); ?>"></script>
    </head>

    <body>
        <div class="header">
            <div>LICENSE SQUARE</div>
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
                    <div class="all_license">総数：</div>
                    <div><?=count($license)?></div>
                    
                    <form method="post" class="search-box">
                        <input type="text" placeholder="資格名を入力" name="searcher">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                    
                    <form action="a_sort.php" method = "POST">
                    <select name='sort'>
                    <option value='option1'>名前順</option>
                    <option value='option2'>有効期間順</option>
                    <option value='option3'>資格分野</option>
                    </select>
                    <input type="submit"name="submit"value="sort" id="sort">
                    </form>
                </div>

                <div class="license_column">
                    <div class="all_li_name">資格名</div>
                    <div class="valid_period">有効期間</div>
                    <div class="li_div">資格区分</div>
                    <div class="li_fi">資格分野</div>
                    <div class="li_auth">発行機関</div>
                </div>

                <?php for ($i = 0; $i < count($license); $i++): ?>
                    <div class="all_license_data">
                        <div class="li_name"><?=$license[$i]['li_name']?></div>
                        <div class="valid_period"><?=$license[$i]['valid_period']?></div>
                        <div class="li_div"><?=$license[$i]['li_division']?></div>
                        <div class="li_fi"><?=$license[$i]['li_field']?></div>
                        <div class="li_auth"><?=$license[$i]['li_authority']?></div>
                        <button class="detail" onclick="showAllDetail(<?=$license[$i]['li_id']?>)"><img src="../image/detail.png"/></button>
                    </div>
                <?php endfor; ?>
                </div>
            </div>
        </div>
    </body>
</html>