<?php
function db_search_my($chain_flag){

    global $id_num;
    global $view1;
    global $view2;
    global $view3;
    global $view4;
    global $view5;
    global $view6;
    global $view7;
    global $view8;
    global $chain_flag;
    $pdo = new PDO("mysql:host=localhost;dbname=p_license;charset=utf8", "root", "");

    $sql = "SELECT * FROM p_license WHERE user_id = $id_num";
    $stmt = $pdo->prepare($sql);
    $stmt -> execute();


    while ($result = $stmt -> fetch(PDO::FETCH_ASSOC )) {
        if($chain_flag == 1){
            $view7 = $result["li_name"];
        }else{
            $view1 .= $result["user_id"];
            $view2 .= $result["license_id"];
            $view3 .= $result["aqs_date"];
            $view4 .= $result["image_type"];
            $view5 .= $result["image_file"];
            $view6 .= $result["image_size"];
            $view7 .= $result["expiry_date"];
            $view8 .= $result["next_date"];
        }
    }  
    db_search_li($chain_flag);
}
function db_search_li($chain_flag){

    global $id_num;
    global $view9;
    global $view10;
    global $view11;
    global $view12;
    global $view13;
    global $view14;
    global $view15;
    global $chain_flag;
    $pdo = new PDO("mysql:host=localhost;dbname=p_license;charset=utf8", "root", "");

    $sql = "SELECT * FROM test_license WHERE license_id = $id_num";
    $stmt = $pdo->prepare($sql);
    $stmt -> execute();


    while ($result = $stmt -> fetch(PDO::FETCH_ASSOC )) {
        if($chain_flag == 1){
            $view15 = $result["li_name"];
        }else{
            $view9 .= $result["license_id"];
            $view10 .= $result["li_name"];
            $view11 .= $result["update_flag"];
            $view12 .= $result["valid_period"];
            $view13 .= $result["explanation"];
            $view14 .= $result["site_url"];
            $view15 .= $result["superrior_id"];
        }

        if($result["superrior_id"]!=0){
            $id_num = $result["superrior_id"];
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
        <link rel="stylesheet" href="main.css">
        <script type="text/javascript" src="main.js"></script>
    </head>

    <body>
        
        <!--<script src="main1.js"></script>-->
        <div class="header">
            <div>LICENSE SQUARE:資格詳細</div>
            <div class="header_icon">
                <a href="#" class="gear"><img src="gear.png"/></a>
                <a href="#" class="account"><img src="account.png"/></a>
            </div>
        </div>

        <div class="container">
            <div id="menu">
                <ul>
                    <li><a href="mainscreen.html">保有資格</a></li>
                    <li><a href="#">関連資格</a></li>
                    <li><a href="#">資格一覧</a></li>
                    <li><a href="#">資格診断</a></li>
                    

                </ul>
            </div>
    
            <div class="main">
                <div class="main_function">
                    <div class="all_license">総数：</div>
                    <div id="edit_area">1</div>

                    <div class="search-box">
                        <input type="text" placeholder="資格名を入力">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </div>

                    <button id="add" onclick="addLicense()">+Add</button>

        
                </div>
                <?php
                    $id_num = 1;
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
                    <div>
                    <div class="license_detail"><div class="center">ユーザID：</div><div class="margin_r"><?= $view1 ?></div></div>  
                        <div class="license_detail"><div class="center">資格ID：</div><div class="margin_r"><?= $view2 ?></div></div>
                        <div class="license_detail"><div class="center">取得年月日：</div><div class="margin_r"><?= $view3 ?></div></div>  
                        <div class="license_detail"><div class="center">資格画像タイプ：</div><div class="margin_r"><?= $view4 ?></div></div>  
                        <div class="license_detail"><div class="center">資格画像ファイル：</div><div class="margin_r"><?= $view5 ?></div></div>  
                        <div class="license_detail"><div class="center">資格画像サイズ：</div><div class="margin_r"><?= $view6 ?></div></div>  
                        <div class="license_detail"><div class="center">有効期限：</div><div class="margin_r"><?= $view7 ?></div></div> 
                        <div class="license_detail"><div class="center">次回通知日時：</div><div class="margin_r"><?= $view8 ?></div></div>  
                        <div class="license_detail"><div class="center">資格ID：</div><div class="margin_r"><?= $view9 ?></div></div>
                        <div class="license_detail"><div class="center">資格名：</div><div class="margin_r"><?= $view10 ?></div></div>  
                        <div class="license_detail"><div class="center">フラグ：</div><div class="margin_r"><?= $view11 ?></div></div>  
                        <div class="license_detail"><div class="center">有効期限：</div><div class="margin_r"><?= $view12 ?></div></div>  
                        <div class="license_detail"><div class="center">説明：</div><div class="margin_r"><?= $view13 ?></div></div>  
                        <div class="license_detail"><div class="center">URL：</div><div class="margin_r"><?= $view14 ?></div></div> 
                        <div class="license_detail"><div class="center">上位資格：</div><div class="margin_r"><?= $view15 ?></div></div>   

                    </div>

            </div>
        </div>


    </body>
</html>