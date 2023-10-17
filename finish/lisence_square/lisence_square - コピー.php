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
		<form action="account_login/login.php">
				<input type="text" id="log_username" placeholder="username"> <br>
				<input type="password" id="log_pass" placeholder="password"> <button type="button" id="switch">表示</button> <br>
				<script type="text/javascript" src="./button_change/switching.js"></script>
			
				<input type="submit" id="log_submit" value="login">
				
				<p>アカウントが無い場合<button type="button" id="tomake">アカウント作成</button></p>
				<script type="text/javascript" src="./checker.js"></script>
				
		</form>
	</div>
	
	<input type="checkbox" id="makecheck" checked>
	<div id="makeaccount">
		<form action="account_login/makeaccount.php">
				<input type="text" id="make_username" placeholder="username"> <br>
				<input type="email" id="email" placeholder="e-mail"> <br>
				<input type="date" id="birthday"> <br>
			
				<input type="password" id="make_pass" placeholder="password"> <button type="button" id="change">表示</button><br>
				<script type="text/javascript" src="./button_change/changing.js"></script>
			
				<input type="password" id="make_repass" placeholder="password"> <button type="button" id="kirikae">表示</button><br>
				<script type="text/javascript" src="./button_change/kirikae.js"></script>
			
				<input type="submit" id="make_submit" value="create your account">

				<p>アカウントをお持ちの場合<button type="button" id="tologin">ログイン</button> </p>
				<script type="text/javascript" src="./makechecker.js"></script>
				
		</form>
	</div>
	
	

</body>
</html>
