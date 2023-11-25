<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>LICENSE SQUARE</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="main.css?<?php echo date('Ymd-Hi'); ?>">
    </head>

    <body>
        <div class="header">
            <div>LICENSE SQUARE</div>
            <div class="header_icon">
                <a href="account_menu.php" class="gear"><img src="../image/gear.png"/></a>
                <a href="#" class="account"><img src="../image/account.png"/></a>
            </div>
        </div>

        <div class="container">
            <div id="menu">
                <ul>
                    <li><a href="../main/main.php">保有資格</a></li>
                    <li><a href="relative_licenses_main.php">関連資格</a></li>
                    <li><a href="#">資格一覧</a></li>
                    <li><a href="#">資格診断</a></li>
                </ul>
            </div>
    
            <div class="main">
            	<div class="main_function">
                    <div class="search-box">
                        <input type="text" placeholder="資格名を入力" id="searcher">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </div>     
                    
                </div>
                <?php include('group.php'); ?>
            </div>
        </div>
    </body>
</html>