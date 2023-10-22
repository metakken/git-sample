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
        <?php
            session_start();
            $_SESSION['user_id'] = 1;
            $_SESSION['license_id'] = 4;
        ?>

        <div class="header">
            <div>LICENSE SQUARE</div>
            <div class="header_icon">
                <a href="#" class="gear"><img src="gear.png"/></a>
                <a href="#" class="account"><img src="account.png"/></a>
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
                <div class="main_function">
                    <div class="all_license">総数：</div>
                    <div id="edit_area">2</div>

                    <div class="search-box">
                        <input type="text" placeholder="資格名を入力" id="searcher">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </div>

                    <button id="add" onclick="addLicense()">+Add</button>

        
                </div>

                <div id="target">
                    <div id="main_target">
                        <div class="license_data">
                            <div>
                                <div class="license_name">テスト資格(license_id=1の資格、つまり「草むしり検定」)</div>
                                <div class="deadline">有効期限：</div>
                            </div>
    
                            <button id="bell"><img src="bell.png"/></button>
                            <button id="garbage" onclick="removeLicense()"><img src="garbage.png"/></button>
                            <form action="l_detail.php" method="post">
                                <button id="detail" type="submit" name="l1"><a href="l_detail.php"><img src="detail.png"/></a></button>
                            </form>
                            
                        </div>
                    </div>
                    <div class="license_data">
                            <div>
                                <div class="license_name">テスト資格(license_id=4の資格、つまり「テスト資格」)</div>
                                <div class="deadline">有効期限：</div>
                            </div>
    
                            <button id="bell"><img src="bell.png"/></button>
                            <button id="garbage" onclick="removeLicense()"><img src="garbage.png"/></button>
                            <form action="l_detail.php" method="post">
                                <button id="detail" type="submit" name="l4"><a href="l_detail.php"><img src="detail.png"/></a></button>
                            </form>
                    </div>
                </div>

            </div>
        </div>


    </body>
</html>