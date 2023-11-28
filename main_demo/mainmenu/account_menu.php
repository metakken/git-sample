<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>LICENSE SQUARE</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="main.css?<?php echo date('Ymd-Hi'); ?>">
    </head>

    <body>
        <div class="header">
            <div>LICENSE SQUARE：アカウント</div>
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
				<form action="a_menu_changer.php" method="post">
				<p>変更したい項目に入力してください</p>
				<label>姓:</label><input type="text" name="newlast" placeholder="変更後の姓を入力"><br>
				<label>名:</label><input type="text" name="newfirst" placeholder="変更後の名を入力"><br>
				<label>メールアドレス：</label><input type="email" name="newmail" placeholder="変更後のメールアドレスを入力"><br>
				<label>生年月日：</label><input type="date" name="newbirth" placeholder="変更後の生年月日を入力"><br>
				<label>パスワード：</label><input type="password" id="newpass" name="newpass" placeholder="変更後のパスワードを入力"><br>
				<script type="text/javascript" src="kirikae2.js"></script>
				
				<input type="submit" id="change" value="変更">
				</form>
                    </div>     
                    
                </div>
            </div>
        </div>
    </body>
</html>


