<?php
// データベースに接続
function connectDB() {
    $param = 'mysql:dbname=license_square;host=localhost';
    try {
        // ローカル環境で実行してるとき
        $pdo = new PDO($param, 'root', '');
        return $pdo;

    } catch (PDOException $e) {
        exit($e->getMessage());
    }
}
?>