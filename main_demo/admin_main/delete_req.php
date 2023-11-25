<?php
session_start();
require_once '../connectDB.php';
$pdo = connectDB();
$sql = 'DELETE FROM request WHERE request_id = :request_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':request_id', (int)$_GET['request'], PDO::PARAM_INT);
$stmt->execute();

header('Location:request.php');
exit();
?>