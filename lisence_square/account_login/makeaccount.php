<?php
  $goname = $_POST['make_username'];
  $goemail = $_POST['email'];
  $gobirth = $_POST['birthday'];
  $gopass = $_POST['make_pass'];
  $gorepass = $_POST['make_repass'];
  
  
	if(empty($gobirth)){
		header('Location:../lisence_square.php');
    	exit();
	}
  

  if ($goname == '' || $gopass == '' || $gorepass == '') {
    header('Location:../lisence_square.php');
    exit();
  }
  
  if ($gopass != $gorepass ) {
    header('Location:../lisence_square.php');
    exit();
  }

  $dsn = 'mysql:host=localhost;dbname=pm_ensyu;charset=utf8';
  $username = 'root';
  $db_password = 'Aitnsa7645';
  
  
  try {
    $db = new PDO($dsn, $username, $db_password);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    
    if($goemail == ''){
    	$stmt = $db->prepare(
        	"INSERT INTO user 
        	(firstname,birthday,password)
        	VALUES ('$goname',$gobirth,'$gopass')");
    }
    
    else{
    	$stmt = $db->prepare(
        	"INSERT INTO user 
        	(firstname,birthday,mail,password)
        	VALUES ('$goname',$gobirth,'$goemail','$gopass')");
    }
    




    $stmt->execute();

    header('Location:ok.php ');
    exit();
  } catch(PDOException $e) {
    die('エラー：' . $e->getMessage());
  }



