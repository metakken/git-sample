<?php
session_start();

function db_search_my($chain_flag){
//テーブルp_licenseに入ってる情報の取得・表示
    global $id_num;
    global $view1;
    global $view2;
    global $view3;
    global $view4;
    global $chain_flag;
    $pdo = new PDO("mysql:host=localhost;dbname=license_square;charset=utf8", "root", "");

    $sql = "SELECT * FROM p_license WHERE license_id = $id_num";
    $stmt = $pdo->prepare($sql);
    $stmt -> execute();


    while ($result = $stmt -> fetch(PDO::FETCH_ASSOC )) {
        if($chain_flag == 1){
            $view3 = $result["li_name"];
        }else{
            $view1 .= $result["aqs_date"];
            $view2 .= $result["image_file"];
            $view3 .= $result["expiry_date"];
            $view4 .= $result["next_date"];
        }
    }  
    db_search_li($chain_flag);
}
function db_search_li($chain_flag){
//テーブルlicenseに入ってる情報の取得・表示
    global $id_num;
    global $view5;
    global $view6;
    global $view7;
    global $view8;
    global $view9;
    global $view10;
    global $view11;
    global $view12;
    global $view13;
    global $chain_flag;
    $pdo = new PDO("mysql:host=localhost;dbname=license_square;charset=utf8", "root", "");

    $sql = "SELECT * FROM license WHERE li_id = $id_num";
    $stmt = $pdo->prepare($sql);
    $stmt -> execute();


    while ($result = $stmt -> fetch(PDO::FETCH_ASSOC )) {
        if($chain_flag == 1){
            $view13 = $result["li_name"];
        }else{
            $view5 .= $result["li_name"];
            $view6 .= $result["update_flag"];
            $view7 .= $result["valid_period"];
            $view8 .= $result["li_division"];
            $view9 .= $result["li_field"];
            $view10 .= $result["li_authority"];
            $view11 .= $result["explanation"];
            $view12 .= $result["site_url"];
            $view13 .= $result["superior_id"];
        }

        if($result["superior_id"]!=0){
            $id_num = $result["superior_id"];
            $chain_flag = 1;
            db_search_li($chain_flag);
        }
    }  
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>メイン画面</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../main.css?<?php echo date('Ymd-Hi'); ?>">
    </head>

    <body>
        
        <!--<script src="main1.js"></script>-->
        <div class="header">
            <div>LICENSE SQUARE : 保有資格詳細</div>
            <div class="header_icon">
                <a href="#" class="gear"><img src="../image/gear.png"/></a>
                <a href="#" class="account"><img src="../image/account.png"/></a>
            </div>
        </div>

        <div class="container">
            <div id="menu">
                <ul>
                    <li><a href="main.php">保有資格</a></li>
                    <li><a href="#">関連資格</a></li>
                    <li><a href="#">資格一覧</a></li>
                    <li><a href="#">資格診断</a></li>
                </ul>
            </div>
    
            <div class="main">
            
            <?php
                    $id_num = (int)$_GET['license'];
                    $view1 = "";
                    $view2 = "";
                    $view3 = "";
                    $view4 = "";
                    $view5 = "";
                    $view6 = "";
                    $view7 = "";
                    $view8 = "";
                    $view9 = "";
                    $view10 = "";
                    $view11= "";
                    $view12 = "";
                    $view13 = "";
                    $view14 = "";
                    $view15 = "";
                    $chain_flag = 0;
                        db_search_my($chain_flag);
                ?>
                <div class="main_function">
                    <div class="license_name"><div class="center">資格名：</div><div class="margin_r"><?= $view5 ?></div></div>  
                </div>
                <div>
                    <div class="license_detail"><div class="center">取得年月日：</div><div class="margin_r"><?= $view1 ?></div></div>  
                    <div class="license_detail"><div class="center">有効期限：</div><div class="margin_r"><?= $view3 ?></div></div>  
                    <div class="license_detail"><div class="center">次回通知日時：</div><div class="margin_r"><?= $view4 ?></div></div>  
                    <div class="license_detail"><div class="center">更新フラグ：</div><div class="margin_r"><?= $view6 ?></div></div>  
                    <div class="license_detail"><div class="center">有効期間：</div><div class="margin_r"><?= $view7 ?></div></div> 
                    <div class="license_detail"><div class="center">資格区分：</div><div class="margin_r"><?= $view8 ?></div></div>  
                    <div class="license_detail"><div class="center">資格分野：</div><div class="margin_r"><?= $view9 ?></div></div>
                    <div class="license_detail"><div class="center">発行機関：</div><div class="margin_r"><?= $view10 ?></div></div>  
                    <div class="license_detail"><div class="center">説明：</div><div class="margin_r"><?= $view11 ?></div></div>  
                    <div class="license_detail"><div class="center">サイトURL：</div><div class="margin_r"><?= $view12 ?></div></div>  
                    <div class="license_detail"><div class="center">上位資格：</div><div class="margin_r"><?= $view13 ?></div></div>  
                    <?php 
                        $pdo = new PDO("mysql:host=localhost;dbname=license_square;charset=utf8", "root", "");

                        $sql_select = "SELECT image_type,image_file FROM p_license WHERE license_id = ?";
                        $result1=$pdo->prepare($sql_select);
                        //パラメータをセット
                        $license_id=(int)$_GET['license'];
                        $result1->bindparam(1,$license_id,PDO::PARAM_INT);
                        $result1->execute();
                        $row = $result1 -> fetch(PDO::FETCH_ASSOC);
                        //取得した画像バイナリデータをbase64で変換。
                        $img = base64_encode($row['image_file']);
                    ?>
                    <!-- エンコードした情報をimgタグに表示 -->
                    <div class="r_image_title">資格画像ファイル：</div>  
                    <img class="r_image" src="data:<?php echo $row['image_type'] ?>;base64,<?php echo $img; ?>" alt="登録されていません"><br>
                    <div class="license_detail"></div>  
                </div>
            </div>
        </div>
    </body>
</html>