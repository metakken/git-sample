<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>LICENSE SQUARE</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="main.css?<?php echo date('Ymd-Hi'); ?>">
        <script type="text/javascript" src="../log_make_changer/tomaking.js"></script>
        
    </head>

    <body>
        <div class="header">
            <div>LICENSE SQUARE</div>
            <div class="header_icon">
                <a href="account_menu.php" class="gear"><img src="../image/gear.png"/></a>
                <a href="#" class="account"><img src="../image/account.png"/></a>
            </div>
        </div>

        <div class="container">
            <div id="menu">
                <ul>
                    <li><a href="../main/main.php">保有資格</a></li>
                    <li><a href="relative_licenses_main.php">関連資格</a></li>
                    <li><a href="#">資格一覧</a></li>
                    <li><a href="#">資格診断</a></li>
                </ul>
            </div>
    
            <div class="main">
				<input type="checkbox" id="logcheck">
	
	<div id="login">
	<form action="join_group.php" method="post">
		<p>参加したいグループのグループＩＤとパスワードを入力してください</p>
		<label>グループID:</label><input type="text" name="group_join_id" placeholder="参加したいグループのＩＤを入力"><br>
		<label>パスワード:</label><input type="password" name="group_join_pass" placeholder="参加したいグループのパスワードを入力"><br>
				
		<input type="submit" id="join_group" value="参加">
		
		<p>グループを作成する場合<button type="button" id="tomake" onclick="clicker();">グループ作成</button></p>

	</form>
	</div>
		

	<input type="checkbox" id="makecheck" checked>
	<div id="makeaccount">
	<form action="make_group.php" method="post">
		<p>作成したいグループのグループ名、グループＩＤ、パスワードを入力してください</p>
		<label>グループ名:</label><input type="text" name="group_name" placeholder="参加したいグループのＩＤを入力"><br>
		<label>グループID:</label><input type="text" name="group_id" placeholder="参加したいグループのＩＤを入力"><br>
		<label>パスワード:</label><input type="password" name="group_pass" placeholder="参加したいグループのパスワードを入力"><br>
				
		<input type="submit" id="make_group" value="作成">
	</form>
		
		<p>グループに参加する場合<button type="button" id="tologin" onclick="clicker2();">グループに参加</button></p>
	</div>
                    </div>     
                    
                </div>
            </div>
        </div>
    </body>
</html>

