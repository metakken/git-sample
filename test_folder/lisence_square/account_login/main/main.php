<?php
	session_start();
	
	$id = $_SESSION['user_id'];
	
	$dsn = 'mysql:host=localhost;dbname=lisence_square;charset=utf8';
	$username = 'root';
	$db_password = 'Aitnsa7645';
	
	try{
		$db = new PDO($dsn, $username, $db_password);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
		$stmt = $db->prepare("SELECT * FROM user WHERE user_id=$id");
    
		$stmt->execute();
		
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if($result){
			echo "ようこそ".$id."さん";
		}
	} catch(PDOException $e) {
				die('エラー：' . $e->getMessage());
			}