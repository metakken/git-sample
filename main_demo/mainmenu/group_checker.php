<?php
	session_start();
	
	$id = $_SESSION['user_id'];
	
	try{
		require_once('../connectDB.php');
    	$db = connectDB();
    	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    	
    	$stmt = $db->prepare("SELECT team_id FROM user WHERE user_id=$id");
		$stmt->execute();
		
		$team_id = $stmt->fetchall(PDO::FETCH_ASSOC);
	}
	
	catch(PDOException $e){
		die('エラー：' . $e->getMessage());
	}
	
	
	if($team_id[0]['team_id']==0){
		header('Location:join_make_group_UI.php');
    	exit();
	}	
	else {
		 header('Location:group_main.php');
    	exit();
	}





?>