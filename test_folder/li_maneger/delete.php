<?php
require_once 'connectDB.php';

$pdo = connectDB();
// 渡された主キーを使ってテーブルから保有資格を削除
$sql = 'DELETE FROM p_license WHERE user_id = :user_id AND license_id = :license_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', (int)$_GET['user'], PDO::PARAM_INT);
$stmt->bindValue(':license_id', (int)$_GET['license'], PDO::PARAM_INT);
$stmt->execute();

header('Location:li_maneger.php');
exit();
?>