<?php
	session_start();
	
	$id = $_SESSION['user_id'];
	
	$group_id = $_POST['group_join_id'];
	$group_pass = $_POST['group_join_pass'];
	
	try{
		require_once('../connectDB.php');
    	$db = connectDB();
    	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    	
    	$stmt = $db->prepare("SELECT * FROM team WHERE team_id='$group_id' AND password='$group_pass'");
		$stmt->execute();
		
		$exist = $stmt->fetchall(PDO::FETCH_ASSOC);
	}
	
	catch(PDOException $e){
		die('エラー：' . $e->getMessage());
	}
	
	
	if(is_null($exist[0]['team_id'])){
		 header('Location:join_make_group_UI.php');
    	exit();
	}
	
	else {
		$stmt = $db->prepare("UPDATE user SET team_id='$group_id' WHERE user_id='$id'");
		$stmt->execute();
		header('Location:group_main.php');
    	exit();
	}





?>