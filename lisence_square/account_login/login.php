<?php
  $name = $_POST['log_username'];
  $pass = $_POST['log_pass'];

  if ($name == '' || $pass == '') {
    header('Location:../lisence_square.php');
    exit();
  }

  $dsn = 'mysql:host=localhost;dbname=pm_ensyu;charset=utf8';
  $db_user = 'root';
  $db_password = 'Aitnsa7645';

  try {
    $db = new PDO($dsn, $db_user, $db_password);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
   
	$stmt = $db->prepare(
		"SELECT * FROM user WHERE firstname='$name' AND password='$pass'"
	);
	$stmt->execute();
	
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	if($result){
		header('Location:../lisence_square.php');
    	exit();
    }
    
    else{
    	header('Location:test2.php');
    	exit();
    }
  

    
  } catch(PDOException $e) {
    die('エラー：' . $e->getMessage());
  }
