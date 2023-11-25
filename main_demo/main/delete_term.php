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

if($_GET['button_flag']==1){
    $stmt->bindValue(':update_term1', NULL, PDO::PARAM_STR);
}else if($_GET['button_flag']==2){
    $stmt->bindValue(':update_term2', NULL, PDO::PARAM_STR);
}else if($_GET['button_flag']==3){
    $stmt->bindValue(':update_term3', NULL, PDO::PARAM_STR);
}else if($_GET['button_flag']==4){
    $stmt->bindValue(':update_term4', NULL, PDO::PARAM_STR);
}else if($_GET['button_flag']==5){
    $stmt->bindValue(':update_term5', NULL, PDO::PARAM_STR);
}else if($_GET['button_flag']==6){
    $stmt->bindValue(':update_term6', NULL, PDO::PARAM_STR);
}else if($_GET['button_flag']==7){
    $stmt->bindValue(':update_term7', NULL, PDO::PARAM_STR);
}else if($_GET['button_flag']==8){
    $stmt->bindValue(':update_term8', NULL, PDO::PARAM_STR);
}else if($_GET['button_flag']==9){
    $stmt->bindValue(':update_term9', NULL, PDO::PARAM_STR);
}else if($_GET['button_flag']==10){
    $stmt->bindValue(':update_term10', NULL, PDO::PARAM_STR);
}

$stmt->execute();

header('Location:l_detail.php?license='.$_GET['license']);
exit();
?>