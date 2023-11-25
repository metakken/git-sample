<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>LICENSE SQUARE</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="start_style.css?<?php echo date('Ymd-Hi'); ?>">
    </head>

    <body>
        <div class="header">
            <div>LICENSE SQUARE</div>
        </div>

        <div class="container">
    
            <div class="main">
            	<input type="checkbox" id="logcheck">
				<div id="login">
					<form action="1_account_login/login.php" method="post">
						<label>ID:</label>	<input type="text" name="login_id" placeholder="ID"> <br>
						<label>パスワード:</label>	<input type="password" name="log_pass" id="log_pass" placeholder="password"> <button type="button" id="switch">表示</button> <br>
						<script type="text/javascript" src="1_start_function_1/switching.js"></script>
			
						<input type="submit" id="log_submit" value="login">
				
						<p>アカウントが無い場合<button type="button" id="tomake">アカウント作成</button></p>
						<script type="text/javascript" src="./log_make_changer/tomake.js"></script>
					</form>
				</div>
	
				<input type="checkbox" id="makecheck" checked>
				<div id="makeaccount">
					<form action="1_account_login/makeaccount.php" method="post">
						<label>ID:</label>	<input type="text" name="make_id" placeholder="ID"> <br>
						<label>姓:</label>	<input type="text" name="make_lastname" placeholder="lastname"> <br>
						<label>名:</label>	<input type="text" name="make_firstname" placeholder="firstname"> <br>
						<label>メールアドレス:</label>	<input type="email" name="email" placeholder="e-mail"> <br>
						<label>生年月日:</label>	<input type="date" name="birthday"> <br>
			
						<label>パスワード:</label>	<input type="password" name="make_pass" id="make_pass" placeholder="password"> <button type="button" id="change">表示</button><br>
						<script type="text/javascript" src="1_start_function_1/changing.js"></script>
						
						<label>パスワード(確認):</label>	<input type="password" name="make_repass" id="make_repass" placeholder="password"> <button type="button" id="kirikae">表示</button><br>
						<script type="text/javascript" src="1_start_function_1/kirikae.js"></script>
					
						<input type="submit" id="make_submit" value="create your account">

						<p>アカウントをお持ちの場合<button type="button" id="tologin">ログイン</button> </p>
						<script type="text/javascript" src="./log_make_changer/tologin.js"></script>
					
					</form>
				</div>
            </div>
        </div>
    </body>
</html>