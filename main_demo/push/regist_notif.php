<?php
session_start();
require_once('../connectDB.php');

if(is_numeric(file_get_contents('php://input'))){   // 通知の設定
    // 対象の保有資格の情報取得
    $pdo = connectDB();
    $sql = 'SELECT * FROM p_license WHERE user_id = :user AND license_id = :license';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user',$_SESSION['user_id'],PDO::PARAM_STR);
    $stmt->bindValue(':license',(int)file_get_contents('php://input'),PDO::PARAM_INT);
    $stmt->execute();
    $exist = $stmt->fetch();
    if($exist){ // 資格が存在するとき
        if(empty($exist['next_date'])){ // 通知をONにするとき
            $cycle = "+1 years";
            if($exist['notif_cycle']){
                $cycle = $exist['notif_cycle'];
            }
            $message = "";
            $now = new DateTime();
            $set_date = new DateTime();
            $expiry_date = new DateTime($exist['expiry_date']);
            $set_date->modify($cycle);

            if($set_date > $expiry_date){   // 通知周期で通知設定日が有効期限日を超えるとき
                $set_date = clone $expiry_date;
                $set_date->modify('-1 month');
                if($now >= $set_date){   // 有効期限日の一月前を過ぎているとき
                    $set_date = clone $expiry_date;
                    $set_date->modify('-1 week');
                    if($now >= $set_date){   // 一週間前を過ぎているとき
                        $set_date = clone $expiry_date;
                        $set_date->modify('-3 days');
                        if($now >= $set_date){   // 三日前を過ぎているとき
                            $set_date = clone $expiry_date;
                            $set_date->modify('-1 days');
                            if($now = $set_date){   // 一日前のとき
                                $set_date = clone $expiry_date;
                                if($now = $expiry_date){   // 有効期限日の時
                                    $set_date = NULL;
                                    $message = "本日が有効期限日です。";
                                }
                            }
                        }
                    }
                }
            }

            if($set_date != NULL){
                $set_date = $set_date->format('Y-m-d'); // 文字列に変換
                $message = "次回通知日時を「".$set_date."」に設定しました。";
            }
            
            $sql = 'UPDATE p_license SET next_date = :next_date WHERE user_id = :user_id AND license_id = :license';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':next_date', $set_date, PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
            $stmt->bindValue(':license',(int)file_get_contents('php://input'),PDO::PARAM_INT);
            if($stmt->execute()){
                echo $message;
            }
            else {
                echo "false";
            }
        }
        else{   // 通知をOFFにするとき
            $sql = 'UPDATE p_license SET next_date = NULL WHERE user_id = :user_id AND license_id = :license';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
            $stmt->bindValue(':license',(int)file_get_contents('php://input'),PDO::PARAM_INT);
            if($stmt->execute()){
                echo "true";
            }
            else {
                echo "false";
            }
        }
        exit;
    }
    else{
        echo "false";
        exit;
    }
}
else{   // 通知先を登録
    $pdo = connectDB();
    $sql = 'UPDATE user SET notif_info = :notif_info WHERE user_id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':notif_info', file_get_contents('php://input'), PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
    $stmt->execute();
    exit;
}
?>