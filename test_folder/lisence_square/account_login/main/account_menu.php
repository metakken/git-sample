<!DOCTYPE html>
<html lang ="ja">
<head>
	<meta charset = "UTF-8">
	<title>LISENCE SQUARE account menu</title>
	<link rel="stylesheet" href="style.css" type="text/css">
	
</head>


<body>
	<h1>アカウント管理</h1>
	
	<button type="button" id="back" onclick="location.href='lisence_square.php'">←戻る</button>
	<br>
	<form action="" method="post">
		<p>変更したい項目に入力してください</p>
		<label>名前:</label><input type="text" name="newname" placeholder="変更後の名前を入力"><br>
		<label>メールアドレス：</label><input type="email" name="newmail" placeholder="変更後のメールアドレスを入力"><br>
		<label>生年月日：</label><input type="date" name="newbirth" placeholder="変更後の生年月日を入力"><br>
		<label>パスワード：</label><input type="password" id="newpass" name="newpasse" placeholder="変更後のパスワードを入力"><button type="button" id="kirikae">表示</button><br>
		
			<script type="text/javascript" src="./button_change/kirikae2.js"></script>
				
		<input type="submit" id="change" value="変更">
	</form>
	
	
	<br><br>
	<label>ログアウト:</label> <button type="button" id="logout" onclick="location.href='lisence_square.php'">logout</button>
	
	<br><br>
	<label>アカウントを削除する場合：</label><button type="button" id="delete" onclick="location.href='lisence_square.php'">アカウント削除</button>
	

</body>
</html>
