<?php

	session_start();
	
	
	$id = $_POST['login_id'];
	$pass = $_POST['log_pass'];

  if ($id == '' || $pass == '') {
    header('Location:../lisence_square.php');
    exit();
  }

  $dsn = 'mysql:host=localhost;dbname=lisence_square;charset=utf8';
  $db_user = 'root';
  $db_password = 'Aitnsa7645';

  try {
    $db = new PDO($dsn, $db_user, $db_password);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
   
	$stmt = $db->prepare(
		"SELECT * FROM user WHERE user_id='$id' AND password='$pass'"
	);
	$stmt->execute();
	
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	if($result){
		$_SESSION['user_id'] = $id;
		header('Location:main/main.php');
    	exit();
    }
    
    else{
    	header('Location:../lisence_square.php');
    	exit();
    }
  

    
  } catch(PDOException $e) {
    die('エラー：' . $e->getMessage());
  }
