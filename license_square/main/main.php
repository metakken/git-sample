<?php
session_start();

// データベースに接続
require_once('../connectDB.php');
$pdo = connectDB();

if ($_SERVER['REQUEST_METHOD']) {
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
        <link rel="stylesheet" href="main.css?<?php echo date('Ymd-Hi'); ?>">
        <script type="text/javascript" src="main.js?<?php echo date('Ymd-Hi'); ?>"></script>
    </head>

    <body>
        <div class="header">
            <div>LICENSE SQUARE</div>
            <div class="header_icon">
                <a href="../mainmenu/account_menu.php" class="gear"><img src="../image/gear.png"/></a>
                <a href="#" class="account"><img src="../image/account.png"/></a>
            </div>
        </div>

        <div class="container">
            <div id="menu">
                <ul>
                    <li><a href="main.php">保有資格</a></li>
                    <li><a href="../mainmenu/relative_licenses_main.php">関連資格</a></li>
                    <li><a href="../mainmenu/all_license_main.php">資格一覧</a></li>
                    <li><a href="#">資格診断</a></li>
                </ul>
            </div>
    
            <div class="main">
                <div class="main_function">
                    <div class="all_license">総数：</div>
                    <div><?=count($p_license)?></div>

                    <div class="search-box">
                        <input type="text" placeholder="資格名を入力" id="searcher">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </div>
                    
                    <div class="filter">
                    	<form method="post" action="#">
                    	<p>資格区分</p>
                    	<input type="radio" name="li_division" value="a">a
                    	<input type="radio" name="li_division" value="b">b
                    	<input type="radio" name="li_division" value="f">f
                    	<br>
                    	<p>資格分野</p>
                    	<input type="radio" name="li_field" value="a">a
                    	<input type="radio" name="li_field" value="b">b
                    	<input type="radio" name="li_field" value="f">f
                    	<input type="submit" name="filter" value="フィルター" >
                    	</form>
                    </div>
                    <button id="add" onclick="addLicense()">+Add</button>        
                </div>
                
                <!-- 保有資格表示 -->
                <?php for ($i = 0; $i < count($p_license); $i++): ?>                
                    <div class="license_data">
                        <?php
                            require_once '../connectDB.php';
                            $pdo = connectDB();
                            // 資格名を取得
                            $sql = 'SELECT li_name,li_division,li_field FROM license WHERE li_id = :li_id LIMIT 1';
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindValue(':li_id', $p_license[$i]['license_id'], PDO::PARAM_INT);
                            $stmt->execute();
                            $license = $stmt->fetch();
                        ?>
                        <div>
                        	<div class="license_name">
                        	<?php
                        	$checker = 0;
                        	$ok = 0;
                        	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                        		if(isset($_POST['li_division'])){
                        			$li_division = $_POST['li_division'];
                        			$checker++;
                        		}
                        		if(isset($_POST['li_field'])){
                        			$li_field = $_POST['li_field'];
                        			$checker = $checker+2;
                        		}
                        		
                        		if($checker ==0){
                        		 	echo $license['li_name'];
                        		 	$ok = 1;
                        		 }
                        		 
                        		 else if($checker ==1){
                        		 	if($li_division == $license['li_division']){
                        		 		echo $license['li_name'];
                        		 		$ok = 1;
                        		 	}
                        		 }
                        		 
                        		 else if($checker ==2){
                        		 	if($li_field == $license['li_field']){
                        		 		echo $license['li_name'];
                        		 		$ok = 1;
                        		 	}
                        		 }
                        		 
                        		 else{
                        		 	if($li_field == $license['li_field'] && $li_division == $license['li_division']){
                        		 		echo $license['li_name'];
                        		 		$ok = 1;
                        		 	}
                        		 }
                        		
                        	}
                        	else{
                            	echo $license['li_name'];
                            }
                            ?>
                            </div>
                            <?php 
                            // 有効期限が存在するとき
                            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                            if($ok == 1){
                            if ($p_license[$i]['expiry_date']){
                                echo "<div class='deadline'>有効期限：{$p_license[$i]['expiry_date']}</div>";
                            }
                            else{
                                echo '<div class="deadline">有効期限：　　―</div>';
                            }
                            }
                            }
                            else{
                            if ($p_license[$i]['expiry_date']){
                                echo "<div class='deadline'>有効期限：{$p_license[$i]['expiry_date']}</div>";
                            }
                             else{
                                echo '<div class="deadline">有効期限：　　―</div>';
                            }
                            }
                            
                            ?>
                        </div>
                        <button id="bell" onclick="setNotif(<?= $p_license[$i]['license_id']?>)"><img src="../image/bell.png"/></button>
                        <button id="garbage" onclick="removeLicense(<?= $p_license[$i]['license_id']?>)"><img src="../image/garbage.png"/></button>
                        <button id="detail" onclick="showDetail(<?=$p_license[$i]['license_id']?>)"><img src="../image/detail.png"/></button>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </body>
</html>