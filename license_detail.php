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
                    $pdo = new PDO("mysql:host=localhost;dbname=p_license;charset=utf8", "root", "");

                    $sql = "SELECT * FROM test_license";
                    $stmt = $pdo->prepare($sql);
                    $stmt -> execute();

                    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC )) {
                        print_r($row);
                        echo("<br/>");
                    }
                    ?>
            </div>
        </div>


    </body>
</html>