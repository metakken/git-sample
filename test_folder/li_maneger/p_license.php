<?php
function p_license($user_id, $license_id){
    require_once 'connectDB.php';
    $pdo = connectDB();

    // ユーザの姓を取得
    $sql = 'SELECT lastname FROM user WHERE user_id = :user_id LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch();
    // 資格名を取得
    $sql = 'SELECT li_name FROM license WHERE li_id = :li_id LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':li_id', $license_id, PDO::PARAM_INT);
    $stmt->execute();
    $license = $stmt->fetch();

    // ユーザの姓と資格名を返す
    return array($user['lastname'], $license['li_name']);
}
?>