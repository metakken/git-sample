<?php
	session_start();
	
	$id = $_SESSION['user_id'];
	
	try{
		require_once('../connectDB.php');
    	$db = connectDB();
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
		$stmt = $db->prepare("SELECT team_id FROM user WHERE user_id=:user_id");
		$stmt->bindValue(':user_id', $id, PDO::PARAM_STR);
		$stmt->execute();
		$team_id = $stmt->fetchall(PDO::FETCH_ASSOC);
	}	
	catch(PDOException $e) {
		die('エラー：' . $e->getMessage());
	}
		
	$team = $team_id[0]['team_id'];
	
	if($team!=0){
		try{
			$stmt = $db->prepare("SELECT user_id FROM user WHERE team_id='$team'");
			$stmt->execute();
			$teammate_id = $stmt->fetchall(PDO::FETCH_ASSOC);
		}	catch(PDOException $e) {
				die('エラー：' . $e->getMessage());
			}
			
		for($i=0; $i<count($teammate_id); $i++){
			$teammate[$i] = $teammate_id[$i]['user_id'];
		}
			
			for($j=0; $j<count($teammate); $j++){
			$counter = 0;
				try{
					$stmt = $db->prepare("SELECT license_id FROM p_license WHERE user_id=:user_id");
					$stmt->bindValue(':user_id', $teammate[$j], PDO::PARAM_STR);
					$stmt->execute();
					$teammate_license_id = $stmt->fetchall(PDO::FETCH_ASSOC);
					$counter = count($teammate_license_id);
				}	
				catch(PDOException $e) {
					die('エラー：' . $e->getMessage());
				}
				
				for($k=0; $k<$counter; $k++){
					$teammate_license_id_all[$k] = $teammate_license_id[$k]['license_id'];
				}
				
				for($l=0; $l<count($teammate_license_id_all); $l++){
					try{
						$stmt = $db->prepare("SELECT li_name FROM license WHERE li_id=$teammate_license_id_all[$l]");
						$stmt->execute();
						$teammate_license_name = $stmt->fetchall(PDO::FETCH_ASSOC);
						$teammate_license_name_all[$l] = $teammate_license_name[0]['li_name'];
					}	
					catch(PDOException $e) {
						die('エラー：' . $e->getMessage());
					}
				}
				
				try{
					$stmt = $db->prepare("SELECT lastname,firstname FROM user WHERE user_id=:user_id");
					$stmt->bindValue(':user_id', $teammate[$j], PDO::PARAM_STR);
					$stmt->execute();
					$teammate_name = $stmt->fetchall(PDO::FETCH_ASSOC);
				}	
				catch(PDOException $e) {
					die('エラー：' . $e->getMessage());
				}
				
				echo "<div class=license_data>";
				echo "<div class=license_name>";
			
				echo $teammate_name[0]['lastname'];
				echo $teammate_name[0]['firstname'];
				
				echo "</div>";
				
				echo "<div class=deadline>";
				
				echo '保有資格:';
					
				for($m=0; $m<$counter; $m++){
					echo $teammate_license_name_all[$m];
					if($m<$counter-1){ echo ':';}
				}
				
				echo "<br>";
			echo "</div>";
			echo "</div>";
			}
		}
?>