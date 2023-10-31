<?php
session_start();
require_once '../connectDB.php';
$pdo = connectDB();
// 渡された主キーを使ってテーブルから保有資格を削除
$sql = 'DELETE FROM p_license WHERE user_id = :user_id AND license_id = :license_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
$stmt->bindValue(':license_id', (int)$_GET['license'], PDO::PARAM_INT);
$stmt->execute();

header('Location:main.php');
exit();
?>