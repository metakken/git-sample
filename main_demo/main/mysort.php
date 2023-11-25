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
    $license0 = $stmt->fetchALL();

    $temp=0;
    for($i = 0; $i < count($license0); $i++){
        // 保有資格テーブルからデータをすべて取得
        $sql = 'SELECT * FROM p_license WHERE user_id = :user_id AND license_id = :li_id LIMIT 1';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
        $stmt->bindValue(':li_id', $license0[$i]['li_id'], PDO::PARAM_INT);
        $stmt->execute();
        $t = $stmt->fetch();
        if($t){
            $p_license[$temp] = $t;
            $temp++;
        }
        
    }
    
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
                <a href="../mainmenu/account_menu.php" class="account"><img src="../image/account.png"/></a>
            </div>
        </div>

        <div class="container">
            <div id="menu">
                <ul>
                    <li><a href="../main/main.php">保有資格</a></li>
                    <li><a href="../mainmenu/relative_licenses_main.php">関連資格</a></li>
                    <li><a href="../mainmenu/all_license_main.php">資格一覧</a></li>
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
                    
                    <form action="mysort.php" method = "POST">
                    <select name='sort'>
                    <option value='option1'>名前順</option>
                    <option value='option2'>有効期間順</option>
                    <option value='option3'>資格分野</option>
                    </select>
                    <input type="submit"name="submit"value="sort" id="sort">
                    </form>

                    <button id="add" onclick="addLicense()">+Add</button>        
                </div>
                
                <!-- 保有資格表示 -->
                <?php for ($i = 0; $i < count($p_license); $i++): ?>                
                    <div id="license_data">
                        <?php
                            require_once '../connectDB.php';
                            $pdo = connectDB();
                            // 資格名を取得
                            if($p_license[$i]){
                                $sql = 'SELECT * FROM license WHERE li_id = :li_id LIMIT 1';
                                $stmt = $pdo->prepare($sql);
                                $stmt->bindValue(':li_id', $p_license[$i]['license_id'], PDO::PARAM_INT);
                                $stmt->execute();
                                $license = $stmt->fetch();
                            }
                            
                        ?>
                        <div>
                            <?php
                            if($p_license[$i]){
                                if($sort_info=='option1'){
                                    echo "<div class='license_name'>{$license['li_name']}</div>";
                                }else if($sort_info=='option2'){
                                    echo "<div class='license_name'>{$license['li_name']} (有効期間：{$license['valid_period']})</div>";
                                }else if($sort_info=='option3'){
                                    echo "<div class='license_name'>{$license['li_name']} (資格分野：{$license['li_field']})</div>";
                                }
                                
                            }
                            ?>
                            
                            <?php 
                            if($p_license[$i]){
                                // 有効期限が存在するとき
                                if ($p_license[$i]['expiry_date']){
                                    echo "<div class='deadline'>有効期限：{$p_license[$i]['expiry_date']}</div>";
                                }
                                else{
                                    echo '<div class="deadline">有効期限：　　―</div>';
                                }
                            }
                            
                            ?>
                        </div>
                        <?php
                        if($p_license[$i]){
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
                        }
                            
                        ?>
                        <?php
                        if($p_license[$i]){
                            echo "<button class='garbage' onclick='removeLicense({$p_license[$i]['license_id']})'><img src='../image/garbage.png'/></button>";
                            echo "<button class='detail' onclick='showDetail({$p_license[$i]['license_id']})'><img src='../image/detail.png'/></button>";
                        }
                        ?>

                    </div>
                    <?php
                    if(!$p_license[$i]){
                        echo "<script>document.getElementById('license_data').style.visibility = 'hidden';</script>";
                    }
                    ?>

                <?php endfor; ?>
            </div>
        </div>
    </body>
</html>