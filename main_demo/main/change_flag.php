<?php
session_start();
require_once '../connectDB.php';
$pdo = connectDB();

$sql = 'UPDATE p_license SET achieve_flag = :achieve_flag WHERE user_id = :user_id AND license_id = :license_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
$stmt->bindValue(':license_id', (int)$_GET['license'], PDO::PARAM_INT);
$stmt->bindValue(':achieve_flag', $_GET['achieve_flag'], PDO::PARAM_STR);

$str="000000000000";
if($_GET['bcheck_flag1']=='true'){
    $str = substr_replace($str, '1', 0, 1);
}
if($_GET['bcheck_flag2']=='true'){
    $str = substr_replace($str, '1', 1, 1);
}



if($_GET['scheck_flag1']=='true'){
    $str = substr_replace($str, '1', 2, 1);
}
if($_GET['scheck_flag2']=='true'){
    $str = substr_replace($str, '1', 3, 1);
}
if($_GET['scheck_flag3']=='true'){
    $str = substr_replace($str, '1', 4, 1);
}
if($_GET['scheck_flag4']=='true'){
    $str = substr_replace($str, '1', 5, 1);
}
if($_GET['scheck_flag5']=='true'){
    $str = substr_replace($str, '1', 6, 1);
}
if($_GET['scheck_flag6']=='true'){
    $str = substr_replace($str, '1', 7, 1);
}
if($_GET['scheck_flag7']=='true'){
    $str = substr_replace($str, '1', 8, 1);
}
if($_GET['scheck_flag8']=='true'){
    $str = substr_replace($str, '1', 9, 1);
}
if($_GET['scheck_flag9']=='true'){
    $str = substr_replace($str, '1', 10, 1);
}
if($_GET['scheck_flag10']=='true'){
    $str = substr_replace($str, '1', 11, 1);
}

$stmt->bindValue(':achieve_flag', $str, PDO::PARAM_STR);
$stmt->execute();

header('Location:l_detail.php?license='.$_GET['license']);
exit();
?>