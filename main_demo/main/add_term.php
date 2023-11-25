<?php
session_start();
require_once '../connectDB.php';
$pdo = connectDB();

$sql = 'UPDATE p_license SET update_term1 = :update_term1, update_term2 = :update_term2, update_term3 = :update_term3, update_term4 = :update_term4, update_term5 = :update_term5, update_term6 = :update_term6, update_term7 = :update_term7, update_term8 = :update_term8, update_term9 = :update_term9, update_term10 = :update_term10 WHERE user_id = :user_id AND license_id = :license_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
$stmt->bindValue(':license_id', (int)$_GET['license'], PDO::PARAM_INT);
$stmt->bindValue(':update_term1', $_GET['term1'], PDO::PARAM_STR);
$stmt->bindValue(':update_term2', $_GET['term2'], PDO::PARAM_STR);
$stmt->bindValue(':update_term3', $_GET['term3'], PDO::PARAM_STR);
$stmt->bindValue(':update_term4', $_GET['term4'], PDO::PARAM_STR);
$stmt->bindValue(':update_term5', $_GET['term5'], PDO::PARAM_STR);
$stmt->bindValue(':update_term6', $_GET['term6'], PDO::PARAM_STR);
$stmt->bindValue(':update_term7', $_GET['term7'], PDO::PARAM_STR);
$stmt->bindValue(':update_term8', $_GET['term8'], PDO::PARAM_STR);
$stmt->bindValue(':update_term9', $_GET['term9'], PDO::PARAM_STR);
$stmt->bindValue(':update_term10', $_GET['term10'], PDO::PARAM_STR);

if($_GET['term1']==NULL){
    $stmt->bindValue(':update_term1', "条件1", PDO::PARAM_STR);
}else if($_GET['term2']==NULL){
    $stmt->bindValue(':update_term2', "条件2", PDO::PARAM_STR);
}else if($_GET['term3']==NULL){
    $stmt->bindValue(':update_term3', "条件3", PDO::PARAM_STR);
}else if($_GET['term4']==NULL){
    $stmt->bindValue(':update_term4', "条件4", PDO::PARAM_STR);
}else if($_GET['term5']==NULL){
    $stmt->bindValue(':update_term5', "条件5", PDO::PARAM_STR);
}else if($_GET['term6']==NULL){
    $stmt->bindValue(':update_term6', "条件6", PDO::PARAM_STR);
}else if($_GET['term7']==NULL){
    $stmt->bindValue(':update_term7', "条件7", PDO::PARAM_STR);
}else if($_GET['term8']==NULL){
    $stmt->bindValue(':update_term8', "条件8", PDO::PARAM_STR);
}else if($_GET['term9']==NULL){
    $stmt->bindValue(':update_term9', "条件9", PDO::PARAM_STR);
}else if($_GET['term10']==NULL){
    $stmt->bindValue(':update_term10', "条件10", PDO::PARAM_STR);
}

$stmt->execute();

header('Location:l_detail.php?license='.$_GET['license']);
exit();
?>