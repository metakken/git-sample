<?php
	session_start();
	$id = $_SESSION['user_id'];
	
	$newlast = $_POST['newlast'];
	$newfirst = $_POST['newfirst'];
	$newmail = $_POST['newmail'];
	$newbirth = $_POST['newbirth'];
	$newpass = $_POST['newpass'];
	
	require_once('../connectDB.php');
    	$db = connectDB();
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	
	if($newlast != ''){
		try{
    
			$stmt = $db->prepare("UPDATE user SET lastname='$newlast' WHERE user_id=$id");
    
			$stmt->execute();
		
		} catch(PDOException $e) {
			die('エラー：' . $e->getMessage());
		}
	}
	
	if($newfirst != ''){
		try{
			$stmt = $db->prepare("UPDATE user SET firstname='$newfirst' WHERE user_id=$id");
    
			$stmt->execute();
		
		} catch(PDOException $e) {
			die('エラー：' . $e->getMessage());
		}
	}
	
	if($newmail != ''){
		try{
    
			$stmt = $db->prepare("UPDATE user SET mail='$newmail' WHERE user_id=$id");
    
			$stmt->execute();
		
		} catch(PDOException $e) {
			die('エラー：' . $e->getMessage());
		}
	}
	
	if($newbirth != ''){
		try{
    
			$stmt = $db->prepare("UPDATE user SET birthday='$newbirth' WHERE user_id=$id");
    
			$stmt->execute();
		
		} catch(PDOException $e) {
			die('エラー：' . $e->getMessage());
		}
	}
	
	if($newpass != ''){
		try{
    
			$stmt = $db->prepare("UPDATE user SET password='$newpass' WHERE user_id=$id");
    
			$stmt->execute();
		
		} catch(PDOException $e) {
			die('エラー：' . $e->getMessage());
		}
	}
	
	
	$alert = "<script type='text/javascript'>alert('変更しました');</script>";
			echo $alert;
			echo '<script>location.href = "../main/main.php";</script>';
	
	
?>


