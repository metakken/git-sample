<?php	

	$checker = 0;
    
	try{
		require_once('../connectDB.php');
    	$db = connectDB();
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
		$stmt = $db->prepare("SELECT li_name, update_flag, valid_period, li_division, li_field, li_authority, explanation, site_url from license");
    
		$stmt->execute();
	}	catch(PDOException $e) {
			die('エラー：' . $e->getMessage());
		}
		
	$result = $stmt->fetchall(PDO::FETCH_ASSOC);
	
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    	if(isset($_POST['li_division'])){
    		$li_division = $_POST['li_division'];
    		$checker++;
    	}
    	
    	if(isset($_POST['li_field'])){
     		$li_field = $_POST['li_field'];
     		$checker = $checker+2;
    	}
    	
    	if($checker ==0){
        	for($i = 0; $i<count($result); $i++){
		
				echo "<div class=license_data>";
		
				echo "<div class=license_name>";
				echo $result[$i]['li_name'];
				echo "</div>";
		
				echo "<div class=deadline>";
				if($result[$i]['update_flag']==1){
					echo "更新：有";}
			
				else{ echo "更新：無";}
		
				echo "有効期間：".$result[$i]['valid_period'];
				echo "資格区分：".$result[$i]['li_division'];
				echo "資格分野：".$result[$i]['li_field'];
				echo "発行機関：".$result[$i]['li_authority'];
				echo "説明：".$result[$i]['explanation'];
				echo "URL：".$result[$i]['site_url'];
				echo "<br>";
				echo "</div>";
				echo "</div>";
			}
        }
                        		 
       else if($checker ==1){
       		for($i = 0; $i<count($result); $i++){
       			if($li_division == $result[$i]['li_division']){
	      			echo "<div class=license_data>";
		
					echo "<div class=license_name>";
					echo $result[$i]['li_name'];
					echo "</div>";
			
					echo "<div class=deadline>";
					if($result[$i]['update_flag']==1){
						echo "更新：有";}
				
					else{ echo "更新：無";}
			
					echo "有効期間：".$result[$i]['valid_period'];
					echo "資格区分：".$result[$i]['li_division'];
					echo "資格分野：".$result[$i]['li_field'];
					echo "発行機関：".$result[$i]['li_authority'];
					echo "説明：".$result[$i]['explanation'];
					echo "URL：".$result[$i]['site_url'];
					echo "<br>";
					echo "</div>";
					echo "</div>";
		      	}
       		}
       	}
                        		 
      	else if($checker ==2){
     		for($i = 0; $i<count($result); $i++){
       			if($li_field == $result[$i]['li_field']){
	      			echo "<div class=license_data>";
		
					echo "<div class=license_name>";
					echo $result[$i]['li_name'];
					echo "</div>";
			
					echo "<div class=deadline>";
					if($result[$i]['update_flag']==1){
						echo "更新：有";}
				
					else{ echo "更新：無";}
			
					echo "有効期間：".$result[$i]['valid_period'];
					echo "資格区分：".$result[$i]['li_division'];
					echo "資格分野：".$result[$i]['li_field'];
					echo "発行機関：".$result[$i]['li_authority'];
					echo "説明：".$result[$i]['explanation'];
					echo "URL：".$result[$i]['site_url'];
					echo "<br>";
					echo "</div>";
					echo "</div>";
		      	}
       		}
     	 }
                    
                    
                    
                    
                        		 
     	 else{
     	 	for($i = 0; $i<count($result); $i++){
	      		if($li_field == $result[$i]['li_field'] && $li_division == $result[$i]['li_division']){
	     			echo "<div class=license_data>";
		
					echo "<div class=license_name>";
					echo $result[$i]['li_name'];
					echo "</div>";
			
					echo "<div class=deadline>";
					if($result[$i]['update_flag']==1){
						echo "更新：有";}
				
					else{ echo "更新：無";}
			
					echo "有効期間：".$result[$i]['valid_period'];
					echo "資格区分：".$result[$i]['li_division'];
					echo "資格分野：".$result[$i]['li_field'];
					echo "発行機関：".$result[$i]['li_authority'];
					echo "説明：".$result[$i]['explanation'];
					echo "URL：".$result[$i]['site_url'];
					echo "<br>";
					echo "</div>";
					echo "</div>";
		      	}
    		}
     	}
     }
	
	
	else{
	for($i = 0; $i<count($result); $i++){
		
		echo "<div class=license_data>";
		
		echo "<div class=license_name>";
		echo $result[$i]['li_name'];
		echo "</div>";
		
		echo "<div class=deadline>";
		if($result[$i]['update_flag']==1){
			echo "更新：有";}
			
		else{ echo "更新：無";}
		
		echo "有効期間：".$result[$i]['valid_period'];
		echo "資格区分：".$result[$i]['li_division'];
		echo "資格分野：".$result[$i]['li_field'];
		echo "発行機関：".$result[$i]['li_authority'];
		echo "説明：".$result[$i]['explanation'];
		echo "URL：".$result[$i]['site_url'];
		echo "<br>";
		echo "</div>";
		echo "</div>";
	}
	}
	
	
?>
