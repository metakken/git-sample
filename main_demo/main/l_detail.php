<?php
    session_start();
    // データベースに接続
    require_once('../connectDB.php');
    $pdo = connectDB();

    // 該当資格の保有資格データを取得
    $sql = 'SELECT * FROM p_license WHERE user_id = :user_id AND license_id = :license_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
    $stmt->bindValue(':license_id', (int)$_GET['license'], PDO::PARAM_INT);
    $stmt->execute();
    $p_license = $stmt->fetch();

    // 該当資格の資格データを取得
    $sql = 'SELECT * FROM license WHERE li_id = :license_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':license_id', (int)$_GET['license'], PDO::PARAM_INT);
    $stmt->execute();
    $license = $stmt->fetch();

    if($license["superior_id"]){
        $sql = 'SELECT * FROM license WHERE li_id = :license_id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':license_id', $license["superior_id"], PDO::PARAM_INT);
        $stmt->execute();
        $superior_license = $stmt->fetch();
        $superior = $superior_license['li_name'];
        
        $sql = 'SELECT * FROM p_license WHERE user_id = :user_id AND license_id = :license_id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
        $stmt->bindValue(':license_id', $superior_license['li_id'], PDO::PARAM_INT);
        $stmt->execute();
        $p_superior = $stmt->fetch();
    }
    else{
        $superior = "";
    }
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>LICENSE SQUARE</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../main.css?<?php echo date('Ymd-Hi'); ?>">
        <script type="text/javascript" src="main.js?<?php echo date('Ymd-Hi'); ?>"></script>
    </head>

    <body>
        <div class="header">
            <div>LICENSE SQUARE : 保有資格詳細</div>
            <div class="header_icon">
                <a href="#" class="gear"><img src="../image/gear.png"/></a>
                <a href="../mainmenu/account_menu.php" class="account"><img src="../image/account.png"/></a>
            </div>
        </div>

        <div class="container">
            <div id="menu">
                <ul>
                    <li><a href="../main/main.php">保有資格</a></li>
                    <li><a href="../mainmenu/relative_licenses_main.php">関連資格</a></li>
                    <li><a href="../mainmenu/all_license_main.php">資格一覧</a></li>
                    <li><a href="#">資格診断</a></li>
                </ul>
            </div>
    
            <div class="main">
                <div class="main_function">
                    <div class="license_name"><div class="center">資格名：</div><div class="margin_r"><?=$license['li_name']?></div></div>  
                </div>
                <div>
                    <div class="license_detail"><div class="center">取得年月日：</div><div class="margin_r"><?=$p_license['aqs_date']?></div></div>  
                    <div class="license_detail"><div class="center">有効期限：</div><div class="margin_r"><?=$p_license['expiry_date']?></div></div>  
                    <div class="license_detail"><div class="center">次回通知日時：</div><div class="margin_r"><?=$p_license['next_date']?></div></div>  
                    <div class="license_detail"><div class="center">更新フラグ：</div><div class="margin_r"><?=$license['update_flag']?></div></div>  
                    <div class="license_detail"><div class="center">有効期間：</div><div class="margin_r"><?=$license['valid_period']?></div></div> 
                    <div class="license_detail"><div class="center">資格区分：</div><div class="margin_r"><?=$license['li_division']?></div></div>  
                    <div class="license_detail"><div class="center">資格分野：</div><div class="margin_r"><?=$license['li_field']?></div></div>
                    <div class="license_detail"><div class="center">発行機関：</div><div class="margin_r"><?=$license['li_authority']?></div></div>  
                    <div class="license_detail"><div class="center">説明：</div><div class="margin_r"><?=$license['explanation']?></div></div>  
                    <div class="license_detail"><div class="center">サイトURL：</div><div class="margin_r"><?=$license['site_url']?></div></div>
                    <?php
                        if ($license['superior_id']){
                            echo '<div class="license_detail2"><div class="center">上位資格：</div><div class="margin_r">'.$superior.'</div><div class="license_data2">';
                            if (!empty($p_superior)){
                                echo "<button id='detail' onclick='showDetail({$license['superior_id']})'><img src='../image/detail.png'/></button>";
                            }
                            else{
                                echo "<button id='detail' onclick='showAllDetail({$license['superior_id']})'><img src='../image/detail.png'/></button>";
                            }
                            echo '</div></div>';
                        }
                    ?>
                    <div class="r_image_title">資格画像ファイル：</div>  
                    <img class="r_image" src="data:<?=$p_license['image_type']?>;base64,<?=base64_encode($p_license['image_file'])?>" alt="登録されていません"><br>
                    <div class="license_detail3"><div class="center">更新情報サイトURL：</div><div class="margin_r"><?=$license['update_site']?></div></div>

                    <div class="license_detail4">
                        <div class="center">更新条件管理：</div>
                        <div class="margin_r">
                        <input type="button" class="b_update" value="✓更新" onclick="changeFlag(<?=$p_license['license_id']?>,'<?=$p_license['achieve_flag']?>')">

                        <input type="button" class="b_update" value="条件追加" onclick="addTerm(<?=$p_license['license_id']?>,'<?=$p_license['update_term1']?>','<?=$p_license['update_term2']?>','<?=$p_license['update_term3']?>','<?=$p_license['update_term4']?>','<?=$p_license['update_term5']?>','<?=$p_license['update_term6']?>','<?=$p_license['update_term7']?>','<?=$p_license['update_term8']?>','<?=$p_license['update_term9']?>','<?=$p_license['update_term10']?>')">

                        <input type="button" class="b_update" value="条件更新" onclick="changeText(<?=$p_license['license_id']?>,'<?=$p_license['update_term1']?>','<?=$p_license['update_term2']?>','<?=$p_license['update_term3']?>','<?=$p_license['update_term4']?>','<?=$p_license['update_term5']?>','<?=$p_license['update_term6']?>','<?=$p_license['update_term7']?>','<?=$p_license['update_term8']?>','<?=$p_license['update_term9']?>','<?=$p_license['update_term10']?>')">
                        <br>
                        </div>
                        
                    </div>
                        <button id="1" class="button1" class="b_update" onclick="deleteTerm(this.id,'<?=$p_license['license_id']?>','<?=$p_license['update_term1']?>','<?=$p_license['update_term2']?>','<?=$p_license['update_term3']?>','<?=$p_license['update_term4']?>','<?=$p_license['update_term5']?>','<?=$p_license['update_term6']?>','<?=$p_license['update_term7']?>','<?=$p_license['update_term8']?>','<?=$p_license['update_term9']?>','<?=$p_license['update_term10']?>')">削除1</button>
                        <button id="2" class="b_update" onclick="deleteTerm(this.id,'<?=$p_license['license_id']?>','<?=$p_license['update_term1']?>','<?=$p_license['update_term2']?>','<?=$p_license['update_term3']?>','<?=$p_license['update_term4']?>','<?=$p_license['update_term5']?>','<?=$p_license['update_term6']?>','<?=$p_license['update_term7']?>','<?=$p_license['update_term8']?>','<?=$p_license['update_term9']?>','<?=$p_license['update_term10']?>')">削除2</button>
                        <button id="3" class="b_update" onclick="deleteTerm(this.id,'<?=$p_license['license_id']?>','<?=$p_license['update_term1']?>','<?=$p_license['update_term2']?>','<?=$p_license['update_term3']?>','<?=$p_license['update_term4']?>','<?=$p_license['update_term5']?>','<?=$p_license['update_term6']?>','<?=$p_license['update_term7']?>','<?=$p_license['update_term8']?>','<?=$p_license['update_term9']?>','<?=$p_license['update_term10']?>')">削除3</button>
                        <button id="4" class="b_update" onclick="deleteTerm(this.id,'<?=$p_license['license_id']?>','<?=$p_license['update_term1']?>','<?=$p_license['update_term2']?>','<?=$p_license['update_term3']?>','<?=$p_license['update_term4']?>','<?=$p_license['update_term5']?>','<?=$p_license['update_term6']?>','<?=$p_license['update_term7']?>','<?=$p_license['update_term8']?>','<?=$p_license['update_term9']?>','<?=$p_license['update_term10']?>')">削除4</button>
                        <button id="5" class="b_update" onclick="deleteTerm(this.id,'<?=$p_license['license_id']?>','<?=$p_license['update_term1']?>','<?=$p_license['update_term2']?>','<?=$p_license['update_term3']?>','<?=$p_license['update_term4']?>','<?=$p_license['update_term5']?>','<?=$p_license['update_term6']?>','<?=$p_license['update_term7']?>','<?=$p_license['update_term8']?>','<?=$p_license['update_term9']?>','<?=$p_license['update_term10']?>')">削除5</button>
                        <button id="6" class="b_update" onclick="deleteTerm(this.id,'<?=$p_license['license_id']?>','<?=$p_license['update_term1']?>','<?=$p_license['update_term2']?>','<?=$p_license['update_term3']?>','<?=$p_license['update_term4']?>','<?=$p_license['update_term5']?>','<?=$p_license['update_term6']?>','<?=$p_license['update_term7']?>','<?=$p_license['update_term8']?>','<?=$p_license['update_term9']?>','<?=$p_license['update_term10']?>')">削除6</button>
                        <button id="7" class="b_update" onclick="deleteTerm(this.id,'<?=$p_license['license_id']?>','<?=$p_license['update_term1']?>','<?=$p_license['update_term2']?>','<?=$p_license['update_term3']?>','<?=$p_license['update_term4']?>','<?=$p_license['update_term5']?>','<?=$p_license['update_term6']?>','<?=$p_license['update_term7']?>','<?=$p_license['update_term8']?>','<?=$p_license['update_term9']?>','<?=$p_license['update_term10']?>')">削除7</button>
                        <button id="8" class="b_update" onclick="deleteTerm(this.id,'<?=$p_license['license_id']?>','<?=$p_license['update_term1']?>','<?=$p_license['update_term2']?>','<?=$p_license['update_term3']?>','<?=$p_license['update_term4']?>','<?=$p_license['update_term5']?>','<?=$p_license['update_term6']?>','<?=$p_license['update_term7']?>','<?=$p_license['update_term8']?>','<?=$p_license['update_term9']?>','<?=$p_license['update_term10']?>')">削除8</button>
                        <button id="9" class="b_update" onclick="deleteTerm(this.id,'<?=$p_license['license_id']?>','<?=$p_license['update_term1']?>','<?=$p_license['update_term2']?>','<?=$p_license['update_term3']?>','<?=$p_license['update_term4']?>','<?=$p_license['update_term5']?>','<?=$p_license['update_term6']?>','<?=$p_license['update_term7']?>','<?=$p_license['update_term8']?>','<?=$p_license['update_term9']?>','<?=$p_license['update_term10']?>')">削除9</button>
                        <button id="10" class="b_update" onclick="deleteTerm(this.id,'<?=$p_license['license_id']?>','<?=$p_license['update_term1']?>','<?=$p_license['update_term2']?>','<?=$p_license['update_term3']?>','<?=$p_license['update_term4']?>','<?=$p_license['update_term5']?>','<?=$p_license['update_term6']?>','<?=$p_license['update_term7']?>','<?=$p_license['update_term8']?>','<?=$p_license['update_term9']?>','<?=$p_license['update_term10']?>')">削除10</button>
                    <div class="term">



                    <?php                    
                        if (preg_match("/10........../",$p_license['achieve_flag'])){
                            echo '<p><input type="checkbox" id=checkbig1 checked><input type="text" size="80" style="border: solid 3px #000" disabled value='.$license['update_term1'].'></p>';  
                            echo '<p><input type="checkbox" id=checkbig2 ><input type="text" size="80" style="border: solid 3px #000" disabled value='.$license['update_term2'].'></p>';
                        }else if(preg_match("/01........../",$p_license['achieve_flag'])){
                            echo '<p><input type="checkbox" id=checkbig1 ><input type="text" size="80" style="border: solid 3px #000" disabled value='.$license['update_term1'].'></p>';
                            echo '<p><input type="checkbox" id=checkbig2 checked><input type="text" size="80" style="border: solid 3px #000" disabled value='.$license['update_term2'].'></p>';
                        }else if(preg_match("/00........../",$p_license['achieve_flag'])){
                            echo '<p><input type="checkbox" id=checkbig1 ><input type="text" size="80" style="border: solid 3px #000" disabled value='.$license['update_term1'].'></p>';
                            echo '<p><input type="checkbox" id=checkbig2 ><input type="text" size="80" style="border: solid 3px #000" disabled value='.$license['update_term2'].'></p>';
                        }else if(preg_match("/11........../",$p_license['achieve_flag'])){
                            echo '<p><input type="checkbox" id=checkbig1 checked><input type="text" size="80" style="border: solid 3px #000" disabled value='.$license['update_term1'].'></p>';
                            echo '<p><input type="checkbox" id=checkbig2 checked><input type="text" size="80" style="border: solid 3px #000" disabled value='.$license['update_term2'].'></p>';
                        }
                    ?>                    


                    <?php
                    
                        if ($p_license['update_term1']!=NULL){
                            if(preg_match("/..1........./",$p_license['achieve_flag'])){
                                echo '<p><input type="checkbox" id=checksmall1 checked><input type="text" id="text1" size="80" placeholder='.$p_license['update_term1'].'></p>';
                            }else{
                                echo '<p><input type="checkbox" id=checksmall1><input type="text" id="text1" size="80" placeholder='.$p_license['update_term1'].'></p>';
                            }
                        }else{
                            echo '<p><input type="checkbox" id=checksmall1 hidden><input type="text" hidden id="text1" size="80" placeholder='.$p_license['update_term1'].'></p>';
                        }
                        if($p_license['update_term2']!=NULL){
                            if(preg_match("/...1......../",$p_license['achieve_flag'])){
                                echo '<p><input type="checkbox" id=checksmall2 checked><input type="text" id="text2" size="80" placeholder='.$p_license['update_term2'].'></p>';
                            }else{
                                echo '<p><input type="checkbox" id=checksmall2><input type="text" id="text2" size="80" placeholder='.$p_license['update_term2'].'></p>';
                            }
                        }else{
                            echo '<p><input type="checkbox" id=checksmall2 hidden><input type="text" hidden id="text2" size="80" placeholder='.$p_license['update_term2'].'></p>';
                        }
                        if($p_license['update_term3']!=NULL){
                            if(preg_match("/....1......./",$p_license['achieve_flag'])){
                                echo '<p><input type="checkbox" id=checksmall3 checked><input type="text" id="text3" size="80" placeholder='.$p_license['update_term3'].'></p>';
                            }else{
                                echo '<p><input type="checkbox" id=checksmall3><input type="text" id="text3" size="80" placeholder='.$p_license['update_term3'].'></p>';
                            }
                        }else{
                            echo '<p><input type="checkbox" id=checksmall3 hidden><input type="text" hidden id="text3" size="80" placeholder='.$p_license['update_term3'].'></p>';
                        }
                        if($p_license['update_term4']!=NULL){
                            if(preg_match("/.....1....../",$p_license['achieve_flag'])){
                                echo '<p><input type="checkbox" id=checksmall4 checked><input type="text" id="text4" size="80" placeholder='.$p_license['update_term4'].'></p>';
                            }else{
                                echo '<p><input type="checkbox" id=checksmall4><input type="text" id="text4" size="80" placeholder='.$p_license['update_term4'].'></p>';
                            }
                        }else{
                            echo '<p><input type="checkbox" id=checksmall4 hidden><input type="text" hidden id="text4" size="80" placeholder='.$p_license['update_term4'].'></p>';
                        }
                        if($p_license['update_term5']!=NULL){
                            if(preg_match("/......1...../",$p_license['achieve_flag'])){
                                echo '<p><input type="checkbox" id=checksmall5 checked><input type="text" id="text5" size="80" placeholder='.$p_license['update_term5'].'></p>';
                            }else{
                                echo '<p><input type="checkbox" id=checksmall5><input type="text" id="text5" size="80" placeholder='.$p_license['update_term5'].'></p>';
                            }
                        }else{
                            echo '<p><input type="checkbox" id=checksmall5 hidden><input type="text" hidden id="text5" size="80" placeholder='.$p_license['update_term5'].'></p>';
                        }
                        if($p_license['update_term6']!=NULL){
                            if(preg_match("/.......1..../",$p_license['achieve_flag'])){
                                echo '<p><input type="checkbox" id=checksmall6 checked><input type="text" id="text6" size="80" placeholder='.$p_license['update_term6'].'></p>';
                            }else{
                                echo '<p><input type="checkbox" id=checksmall6><input type="text" id="text6" size="80" placeholder='.$p_license['update_term6'].'></p>';
                            }
                        }else{
                            echo '<p><input type="checkbox" id=checksmall6 hidden><input type="text" hidden id="text6" size="80" placeholder='.$p_license['update_term6'].'></p>';
                        }
                        if($p_license['update_term7']!=NULL){
                            if(preg_match("/........1.../",$p_license['achieve_flag'])){
                                echo '<p><input type="checkbox" id=checksmall7 checked><input type="text" id="text7" size="80" placeholder='.$p_license['update_term7'].'></p>';
                            }else{
                                echo '<p><input type="checkbox" id=checksmall7><input type="text" id="text7" size="80" placeholder='.$p_license['update_term7'].'></p>';
                            }
                        }else{
                            echo '<p><input type="checkbox" id=checksmall7 hidden><input type="text" hidden id="text7" size="80" placeholder='.$p_license['update_term7'].'></p>';
                        }
                        if($p_license['update_term8']!=NULL){
                            if(preg_match("/.........1../",$p_license['achieve_flag'])){
                                echo '<p><input type="checkbox" id=checksmall8 checked><input type="text" id="text8" size="80" placeholder='.$p_license['update_term8'].'></p>';
                            }else{
                                echo '<p><input type="checkbox" id=checksmall8><input type="text" id="text8" size="80" placeholder='.$p_license['update_term8'].'></p>';
                            }
                        }else{
                            echo '<p><input type="checkbox" id=checksmall8 hidden><input type="text" hidden id="text8" size="80" placeholder='.$p_license['update_term8'].'></p>';
                        }
                        if($p_license['update_term9']!=NULL){
                            if(preg_match("/..........1./",$p_license['achieve_flag'])){
                                echo '<p><input type="checkbox" id=checksmall9 checked><input type="text" id="text9" size="80" placeholder='.$p_license['update_term9'].'></p>';
                            }else{
                                echo '<p><input type="checkbox" id=checksmall9><input type="text" id="text9" size="80" placeholder='.$p_license['update_term9'].'></p>';
                            }
                        }else{
                            echo '<p><input type="checkbox" id=checksmall9 hidden><input type="text" hidden id="text9" size="80" placeholder='.$p_license['update_term9'].'></p>';
                        }
                        if($p_license['update_term10']!=NULL){
                            if(preg_match("/...........1/",$p_license['achieve_flag'])){
                                echo '<p><input type="checkbox" id=checksmall10 checked><input type="text" id="text10" size="80" placeholder='.$p_license['update_term10'].'></p>';
                            }else{
                                echo '<p><input type="checkbox" id=checksmall10><input type="text" id="text10" size="80" placeholder='.$p_license['update_term10'].'></p>';
                            }
                        }else{
                            echo '<p><input type="checkbox" id=checksmall10 hidden><input type="text" hidden id="text10" size="80" placeholder='.$p_license['update_term10'].'></p>';
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>