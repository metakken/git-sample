<?php
	session_start();
	
	$id = $_SESSION['user_id'];
	
	$group_name = $_POST['group_name'];
	$group_id = $_POST['group_id'];
	$group_pass = $_POST['group_pass'];
	
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
	
	
	if(!$exist){
		$stmt = $db->prepare("INSERT INTO team (team_id,team_name,leader_id,password) VALUES ('$group_id','$group_name',:user_id,'$group_pass')");
		$stmt->bindValue(':user_id', $id, PDO::PARAM_STR);
		$stmt->execute();
		$stmt = $db->prepare("UPDATE user SET team_id='$group_id' WHERE user_id=:user_id");
		$stmt->bindValue(':user_id', $id, PDO::PARAM_STR);
		$stmt->execute();
		header('Location:group_main.php');
    	exit();
	}
	
	
	else {
		 header('Location:join_make_group_UI.php');
    	exit();
	}
?>