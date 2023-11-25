<script>
<?php
    session_start();
    // データベースに接続
    require_once('../connectDB.php');
    $pdo = connectDB();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $sup_id = NULL;
        $sql = 'SELECT * FROM license WHERE li_name = :li_name';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':li_name', $_POST['super'], PDO::PARAM_STR);
        $stmt->execute();
        $super = $stmt->fetch();
        if($super){
            $sup_id = $super["li_id"];
        }

        if($super || !$_POST['super']){
            $sql = 'UPDATE license SET li_name=:li_name, update_flag=:update_flag, valid_period=:valid_period, li_division=:li_div, li_field=:li_fi, li_authority=:li_auth, pass_rate=:pass_rate, 
            li_direction=:li_dir, explanation=:exp, site_url=:site_url, superior_id=:sup_id, update_term1=:term1, update_term2=:term2, update_site=:update_site WHERE li_id = :li_id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':li_id', (int)$_GET['license'], PDO::PARAM_INT);
            $stmt->bindValue(':li_name', $_POST['li_name'], PDO::PARAM_STR);
            $stmt->bindValue(':update_flag', isset($_POST["check"]) ? 1 : 0, PDO::PARAM_INT);
            $stmt->bindValue(':valid_period', $_POST['valid_period'], PDO::PARAM_STR);
            $stmt->bindValue(':li_div', $_POST['li_div'], PDO::PARAM_STR);
            $stmt->bindValue(':li_fi', $_POST['li_fi'], PDO::PARAM_STR);
            $stmt->bindValue(':li_auth', $_POST['li_auth'], PDO::PARAM_STR);
            $stmt->bindValue(':pass_rate', isset($_POST["pass_rate"]) ? $_POST["pass_rate"] : NULL, PDO::PARAM_NULL);
            $stmt->bindValue(':li_dir', isset($_POST["li_dir"]) ? $_POST["li_dir"] : NULL, PDO::PARAM_NULL);
            $stmt->bindValue(':exp', ($_POST["exp"]!=="") ? $_POST["exp"] : NULL);
            $stmt->bindValue(':site_url', ($_POST["site_url"]!=="") ? $_POST["site_url"] : NULL);
            $stmt->bindValue(':sup_id', $sup_id, PDO::PARAM_INT);
            $stmt->bindValue(':term1', ($_POST["term1"]!=="") ? $_POST["term1"] : NULL);
            $stmt->bindValue(':term2', ($_POST["term2"]!=="") ? $_POST["term2"] : NULL);
            $stmt->bindValue(':update_site', ($_POST["update_site"]!=="") ? $_POST["update_site"] : NULL);
            $stmt->execute();
            header('Location:../admin_main/admin_main.php');
            exit();
        }
        else{
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
            }
            else{
                $superior = "";
            }
            echo "alert('上位資格が資格マスタに存在していません。');";
        }
    }
    else{
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
        }
        else{
            $superior = "";
        }
    }
?>
</script>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>LICENSE SQUARE：管理者ページ</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../main.css?<?php echo date('Ymd-Hi'); ?>">
        <link rel="stylesheet" href="admin_main.css?<?php echo date('Ymd-Hi'); ?>">
        <script type="text/javascript" src="admin_main.js?<?php echo date('Ymd-Hi'); ?>"></script>
    </head>

    <body>
        <div class="header">
            <div>LICENSE SQUARE：資格編集</div>
            <div class="header_icon">
                <a href="#" class="gear"><img src="../image/gear.png"/></a>
                <a href="#" class="account"><img src="../image/account.png"/></a>
            </div>
        </div>

        <div class="container">
            <div id="menu">
                <ul>
                    <li><a href="../admin_main/admin_main.php">資格追加・編集</a></li>
                    <li><a href="../admin_main/request.php">リクエスト一覧</a></li>
                    <li><a href="../push/push_notif.php">通知一斉送信</a></li>
                </ul>
            </div>
    
            <div class="edit_contents">
                <form method="post" enctype="multipart/form-data" style="max-width: 48%;">
                    <p><label>資格名</label></p>
                    <input type="text" name="li_name" value=<?=$license['li_name']?> required>
                    <div class="check_container">
                        <label >要更新</label>
                        <?php
                        if($license['update_flag']){
                            echo '<input type="checkbox" name="check" checked>';
                        }else{
                            echo '<input type="checkbox" name="check">';
                        }
                        ?>
                    </div>
                    <p><label>有効期間</label></p>
                    <input type="text" name="valid_period" value='<?=$license["valid_period"]?>' required>
                    <p><label>資格区分</label></p>
                    <input type="text" name="li_div" value=<?=$license['li_division']?> required>
                    <p><label>資格分野</label></p>
                    <input type="text" name="li_fi" value=<?=$license['li_field']?> required>
                    <p><label>発行機関</label></p>
                    <input type="text" name="li_auth" value=<?=$license['li_authority']?> required>
                    <p><label>合格率</label></p>
                    <input type="text" name="pass_rate" value=<?=$license['pass_rate']?>>
                    <p><label>資格指向性</label></p>
                    <input type="text" name="li_dir" value=<?=$license['li_direction']?>>
                    <p><label>説明</label></p>
                    <textarea name="exp"><?=$license['explanation']?></textarea>
                    <p><label>サイトURL</label></p>
                    <textarea name="site_url"><?=$license['site_url']?></textarea>
                    <p><label>上位資格</label></p>
                    <input type="text" name="super" value=<?=$superior?>>
                    <p><label>更新条件①</label></p>
                    <textarea name="term1"><?=$license['update_term1']?></textarea>
                    <p><label>更新条件②</label></p>
                    <textarea name="term2"><?=$license['update_term2']?></textarea>
                    <p><label>更新情報サイト</label></p>
                    <textarea name="update_site"><?=$license['update_site']?></textarea>
                    <p><button type="submit" id="edit_button">登録</button></p>
                </form>
            </div>
        </div>
    </body>
</html>