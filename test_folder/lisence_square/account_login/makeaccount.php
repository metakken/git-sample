<?php
	
	session_start();
	
	$id = $_POST['make_id'];
	$lastname = $_POST['make_lastname'];
	$firstname = $_POST['make_firstname'];
	$email = $_POST['email'];
	$birth = $_POST['birthday'];
	$pass = $_POST['make_pass'];
	$repass = $_POST['make_repass'];
  
  
  
	if(empty($birth)){
		header('Location:../lisence_square.php');
    	exit();
	}
  

	if ($id == '' || $lastname == '' || $firstname == '' || $pass == '' || $repass == '') {
    	header('Location:../lisence_square.php');
    	exit();
	}
  
	if($pass != $repass ) {
		header('Location:../lisence_square.php');
	exit();
	}

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
			$alert = "<script type='text/javascript'>alert('そのユーザーIDは使われています');</script>";
			echo $alert;
			echo '<script>location.href = "../lisence_square.php";</script>';
			exit();
		}
	} catch(PDOException $e) {
				die('エラー：' . $e->getMessage());
			}
			
	try {
		$db = new PDO($dsn, $username, $db_password);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    
		if($email == ''){
			$stmt = $db->prepare(
			"INSERT INTO user 
			(user_id,firstname,lastname,birthday,password)
			VALUES ('$id','$firstname','$lastname','$birth','$pass')");
		}
	
		else{
			$stmt = $db->prepare(
			"INSERT INTO user 
			(user_id,firstname,lastname,mail,birthday,password)
			VALUES ('$id','$firstname','$lastname','$email','$birth','$pass')");
		}


	$stmt->execute();
	
	$_SESSIOM['user_id'] = $id;
	
    header('Location:../lisence_square.php');
    exit();
  } catch(PDOException $e) {
    die('エラー：' . $e->getMessage());
  }



