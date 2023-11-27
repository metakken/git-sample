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
						<p><label class="title" id="login_label">ログイン</label></p>
	                    <label for="user_id" class="required">ユーザID</label>
						<div><input type="text" name="login_id" id="user_id" placeholder="ID" required></div><br>
	                    <label for="log_pass" class="required">パスワード</label>
						<div class="pass_wrapper">
							<input type="password" name="log_pass" id="log_pass" placeholder="password" required> <button type="button"><i class="fa fa-eye-slash" id="switch"></i></button> <br>
						</div>
						<script type="text/javascript" src="1_start_function_1/switching.js?<?php echo date('Ymd-Hi'); ?>"></script>
			
						<input type="submit" id="log_submit" value="ログイン">
					
						<button type="button" id="tomake">アカウントがない場合</button>
						<script type="text/javascript" src="./log_make_changer/tomake.js?<?php echo date('Ymd-Hi'); ?>"></script>
					</form>
				</div>
	
				<input type="checkbox" id="makecheck" checked>
				<div id="makeaccount">
					<form action="1_account_login/makeaccount.php" method="post">
						<p><label class="title">アカウント登録</label></p>
	                    <label for="user_id" class="required">ユーザID</label>
						<div><input type="text" name="make_id" id="user_id" placeholder="ID" required></div>
	                    <label for="l_name" class="required">姓</label>
	                    <label for="f_name" id="f_label" class="required">名</label>
						<div id="name"><input type="text" name="make_lastname" id="l_name" placeholder="lastname" required>
						<input type="text" name="make_firstname" id="f_name" placeholder="firstname" required></div>
	                    <label for="email">メールアドレス</label>
						<div><input type="email" name="email" id="email" placeholder="e-mail"></div>
	                    <label for="birthday" class="required">生年月日</label>
						<input type="date" name="birthday" id="birthday" required><br>
	                    <label for="make_pass" class="required">パスワード</label>
						<div class="pass_wrapper">
							<input type="password" name="make_pass" id="make_pass" placeholder="password" required> <button type="button"><i class="fa fa-eye-slash" id="change"></i></button><br>
						</div>
						<script type="text/javascript" src="1_start_function_1/changing.js?<?php echo date('Ymd-Hi'); ?>"></script>
						<label for="make_repass" class="required">パスワード確認</label>
						<div class="pass_wrapper">
							<input type="password" name="make_repass" id="make_repass" placeholder="password" required> <button type="button"><i class="fa fa-eye-slash" id="kirikae"></i></button><br>
						</div>
						<script type="text/javascript" src="1_start_function_1/kirikae.js?<?php echo date('Ymd-Hi'); ?>"></script>
					
						<input type="submit" id="make_submit" value="登録">

						<button type="button" id="tologin">アカウントをお持ちの場合</button>
						<script type="text/javascript" src="./log_make_changer/tologin.js?<?php echo date('Ymd-Hi'); ?>"></script>
					</form>
				</div>
            </div>
        </div>
    </body>
</html>