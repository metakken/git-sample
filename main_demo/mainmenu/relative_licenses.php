<?php

	session_start();
	
	$id = $_SESSION['user_id'];		//現在ログインしているユーザーのＩＤを$idに代入(セッション機能)
	
//ユーザーの全保有資格の資格ＩＤを取得
	try{
		require_once('../connectDB.php');
    	$db = connectDB();
		if(!empty($_POST['searcher'])){
			$sql = 'SELECT * FROM license WHERE li_name LIKE :li_name';
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':li_name', '%'.$_POST['searcher'].'%', PDO::PARAM_STR);
			$stmt->execute();
			$license = $stmt->fetchAll();		
			$tmp = [];
			foreach ($license as $item) {
				$tmp[] = 'license_id = '.$item['li_id'];
			}		
			$sql = 'SELECT license_id FROM p_license WHERE user_id = :user_id AND ('.implode(' OR ', $tmp).')';
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':user_id', $id, PDO::PARAM_STR);
			$stmt->execute();
		}
		else{
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);    
			$stmt = $db->prepare("SELECT license_id FROM p_license WHERE user_id=:user_id");		//ユーザーの全保有資格の資格ＩＤを取得する命令
			$stmt->bindValue(':user_id', $id, PDO::PARAM_STR);
			$stmt->execute();
		}
		$my_all_license = $stmt->fetchall(PDO::FETCH_ASSOC);		//ユーザーの全保有資格の資格ＩＤを$my_all_licenseに代入	
	}
	
	catch(PDOException $e){
		die('エラー：' . $e->getMessage());
	}
//ユーザーの全保有資格の資格ＩＤ取得終了

	if(count($my_all_license)==0)return;

//ユーザーの全保有資格の資格ＩＤを$all_licenses_held_idに代入(扱いやすい配列にするため)
	for($cc = 0; $cc <count($my_all_license); $cc++){
		$all_licenses_held_id[$cc] = $my_all_license[$cc]['license_id'];
	}
//ユーザーの全保有資格の資格ＩＤを$all_licenses_held_idに代入終了


//ユーザの保有資格の数だけ繰り返す
	for($bb = 0; $bb < count($all_licenses_held_id); $bb++){
		$idcounter = 0;
	
	
//ユーザーと同じ資格を保有している人のＩＤを取得
		try{
			$stmt = $db->prepare("SELECT user_id FROM p_license WHERE license_id=$all_licenses_held_id[$bb]");		//ユーザーと同じ資格を保有している人のＩＤを取得する命令
			$stmt->execute();
		
			$same_li_user = $stmt->fetchall(PDO::FETCH_ASSOC);		//ユーザーと同じ資格を保有している人のＩＤを$same_li_userに代入

		}
		catch(PDOException $e) {
			die('エラー：' . $e->getMessage());
		}
//ユーザーと同じ資格を保有している人のＩＤを取得終了


//ユーザーと同じ資格を保有している人のＩＤを$userに代入(扱いやすい配列にするため)
		for($i = 0; $i < count($same_li_user); $i++){
			$user[$i] = ($same_li_user[$i]['user_id']);
		}
//ユーザーと同じ資格を保有している人のＩＤを$userに代入終了


//ユーザと同じ資格を保有している人の持つ全資格のＩＤを取得
		try{
			for($j = 0; $j < count($same_li_user); $j++){
				$stmt = $db->prepare("SELECT license_id FROM p_license WHERE user_id=:user_id");
				$stmt->bindValue(':user_id', $user[$j], PDO::PARAM_STR);
				$stmt->execute();
			
				$relative_license = $stmt->fetchall(PDO::FETCH_ASSOC);
				

				for($k = 0; $k < count($relative_license); $k++){		//ユーザと同じ資格を保有している人の持つ全資格のＩＤを$all_license_idに代入(全員の全保有資格のＩＤを一つの配列に格納するため)
					$all_license_id[$idcounter] = $relative_license[$k]['license_id'];
					$idcounter++;
				}		//ユーザと同じ資格を保有している人の持つ全資格のＩＤを$all_license_idに代入終了
			}
		}
		catch(PDOException $e) {
			die('エラー：' . $e->getMessage());
		}
			
//ユーザと同じ資格を保有している人の持つ全資格のＩＤを取得終了


		$all_unique_id = array_unique($all_license_id);		//被っている資格ＩＤの消去
		
		for($aa = 0; $aa < 4; $aa++){		//関連資格ＴＯＰ３のＩＤと名前を代入する配列を初期化
			$big_three_id[$aa] = 0;
			$big_three_value[$aa] = 0;
		}
		
		
		
		for($l = 0; $l < count($all_unique_id); $l++){
			$counter = 0;
			
			for($m = 0; $m < $idcounter; $m++){
				if($all_unique_id[$l] == $all_license_id[$m]){
					$counter++;
				}
			}
			
			
				
			if($counter > $big_three_value[0]){
				$big_three_value[3] = $big_three_value[2];
				$big_three_value[2] = $big_three_value[1];
				$big_three_value[1] = $big_three_value[0];
				$big_three_value[0] = $counter;
				
				$big_three_id[3] = $big_three_id[2];
				$big_three_id[2] = $big_three_id[1];
				$big_three_id[1] = $big_three_id[0];
				$big_three_id[0] = $all_unique_id[$l];
			}
			
			else if($counter > $big_three_value[1]){
				$big_three_value[3] = $big_three_value[2];
				$big_three_value[2] = $big_three_value[1];
				$big_three_value[1] = $counter;
				
				$big_three_id[3] = $big_three_id[2];
				$big_three_id[2] = $big_three_id[1];
				$big_three_id[1] = $all_unique_id[$l];
			}
			
			else if($counter > $big_three_value[2]){
				$big_three_value[3] = $big_three_value[2];
				$big_three_value[2] = $counter;
			
				$big_three_id[3] = $big_three_id[2];
				$big_three_id[2] = $all_unique_id[$l];
			}
			
			else if($counter > $big_three_value[3]){
				$big_three_value[3] = $counter;
			
				$big_three_id[3] = $all_unique_id[$l];
			}
		}
		
		try{
			$stmt = $db->prepare("SELECT li_name FROM license WHERE li_id=$all_licenses_held_id[$bb]");
			$stmt->execute();
			$license_now = $stmt->fetchall(PDO::FETCH_ASSOC);
			
			for($xx = 0; $xx < 4; $xx++){
				$stmt = $db->prepare("SELECT li_name FROM license WHERE li_id=$big_three_id[$xx]");
				$stmt->execute();
				$license_name = $stmt->fetchall(PDO::FETCH_ASSOC);
				$big_three_license[$xx] = $license_name[0]['li_name'];
			}
			
			
			echo "<div class=license_data>";
			echo "<div class=license_name>";
			
			echo $license_now[0]['li_name'];
			
			echo "</div>";
			
			echo "<div class=deadline>";
			for($yy = 0; $yy < 4; $yy++){
			
				if($big_three_license[$yy] != $license_now[0]['li_name']){
					echo $big_three_license[$yy];
					
					if($yy != 3){
						echo ":";
					}
				}
				
			}
			echo "</div>";
			echo "</div>";
		}
		
		catch(PDOException $e){
			die('エラー：' . $e->getMessage());
		}
		
	}		//bbのループが終了

?>

