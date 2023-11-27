<?php
// データベースに接続
function connectDB() {
    $param = 'mysql:dbname=license_square;host=localhost;charset=utf8';
    try {
        // ローカル環境で実行してるとき
        $pdo = new PDO($param, 'root', '');
        return $pdo;
 
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
}
$pdo=connectDB();



// フォームが送信された場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // テキストボックスの値を取得
    $request_c = isset($_POST['request_c']) ? $_POST['request_c'] : '';
    $request_url = isset($_POST['request_url']) ? $_POST['request_url'] : '';

    // データベースに挿入
    $sql = 'INSERT INTO request (request_c, request_url) VALUES (:request_c, :request_url)';
    $stmt=$pdo->prepare($sql);
    $stmt->bindValue(':request_c', $request_c, PDO::PARAM_STR);
    $stmt->bindValue(':request_url', $request_url, PDO::PARAM_STR);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>データベースに挿入</title>
</head>
<body>

<form method="post" action="">
    <label>
        リクエスト内容:
        <input type="text" name="request_c" id="request_c">
    </label>
    <br>
    <label>
        URL:
        <input type="text" name="request_url" id="request_url">
    </label>
    <br>
    <input type="submit" value="Submit">
</form>

</body>
</html>
