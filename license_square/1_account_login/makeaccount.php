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
		header('Location:../start.php');
    	exit();
	}
  

	if ($id == '' || $lastname == '' || $firstname == '' || $pass == '' || $repass == '') {
    	header('Location:../start.php');
    	exit();
	}
  
	if($pass != $repass ) {
		header('Location:../start.php');
	exit();
	}

	require_once('../connectDB.php');
    $db = connectDB();
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  
	try{    
		$stmt = $db->prepare("SELECT * FROM user WHERE user_id=$id");
    
		$stmt->execute();
		
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if($result){
			$alert = "<script type='text/javascript'>alert('そのユーザーIDは使われています');</script>";
			echo $alert;
			echo '<script>location.href = "../start.php";</script>';
			exit();
		}
	} catch(PDOException $e) {
				die('エラー：' . $e->getMessage());
			}
			
	try {
    
			$stmt = $db->prepare(
			"INSERT INTO user 
			(user_id,firstname,lastname,mail,birthday,password)
			VALUES ('$id','$firstname','$lastname','$email','$birth','$pass')");


	$stmt->execute();
	
	$_SESSION['user_id'] = $id;
		header('Location:../main/main.php');
    	exit();
    	
  } catch(PDOException $e) {
    die('エラー：' . $e->getMessage());
  }



