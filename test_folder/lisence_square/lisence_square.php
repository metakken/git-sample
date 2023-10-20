<!DOCTYPE html>
<html lang ="ja">
<head>
	<meta charset = "UTF-8">
	<title>LISENCE SQUARE</title>
	<link rel="stylesheet" href="style.css" type="text/css">
	
</head>


<body>
	<h1>LISENCE SQUARE</h1>
	
	<input type="checkbox" id="logcheck">
	<div id="login">
		<form action="account_login/login.php" method="post">
			<label>ID:</label>	<input type="text" name="login_id" placeholder="ID"> <br>
			<label>パスワード:</label>	<input type="password" name="log_pass" id="log_pass" placeholder="password"> <button type="button" id="switch">表示</button> <br>
			<script type="text/javascript" src="./display_hidden/switching.js"></script>
			
			<input type="submit" id="log_submit" value="login">
				
			<p>アカウントが無い場合<button type="button" id="tomake">アカウント作成</button></p>
			<script type="text/javascript" src="./log_make_changer/tomake.js"></script>
		</form>
	</div>
	
	<input type="checkbox" id="makecheck" checked>
	<div id="makeaccount">
		<form action="account_login/makeaccount.php" method="post">
			<label>ID:</label>	<input type="text" name="make_id" placeholder="ID"> <br>
			<label>姓:</label>	<input type="text" name="make_lastname" placeholder="lastname"> <br>
			<label>名:</label>	<input type="text" name="make_firstname" placeholder="firstname"> <br>
			<label>メールアドレス:</label>	<input type="email" name="email" placeholder="e-mail"> <br>
			<label>生年月日:</label>	<input type="date" name="birthday"> <br>
			
			<label>パスワード:</label>	<input type="password" name="make_pass" id="make_pass" placeholder="password"> <button type="button" id="change">表示</button><br>
			<script type="text/javascript" src="./display_hidden/changing.js"></script>
			
			<label>パスワード(確認):</label>	<input type="password" name="make_repass" id="make_repass" placeholder="password"> <button type="button" id="kirikae">表示</button><br>
			<script type="text/javascript" src="./display_hidden/kirikae.js"></script>
			
			<input type="submit" id="make_submit" value="create your account">

			<p>アカウントをお持ちの場合<button type="button" id="tologin">ログイン</button> </p>
			<script type="text/javascript" src="./log_make_changer/tologin.js"></script>
				
		</form>
	</div>
	
	

</body>
</html>
