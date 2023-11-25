<?php

	session_start();
	
	
	$id = $_POST['login_id'];
	$pass = $_POST['log_pass'];

  if ($id == '' || $pass == '') {
    header('Location:../start.php');
    exit();
  }

  

  try {
  	require_once('../connectDB.php');
    $db = connectDB();
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
   
	$stmt = $db->prepare(
		"SELECT * FROM user WHERE user_id='$id' AND password='$pass'"
	);
	$stmt->execute();
	
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	if($result){
		$_SESSION['user_id'] = $id;
		if($id == 'admin'){
			header('Location:../admin_main/admin_main.php');
		}
		else{
			header('Location:../main/main.php');
		}
    	exit();
    }
    
    else{
    	header('Location:../start.php');
    	exit();
    }
  

    
  } catch(PDOException $e) {
    die('エラー：' . $e->getMessage());
  }
