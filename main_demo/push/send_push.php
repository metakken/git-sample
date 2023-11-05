<?php
require_once("vendor/autoload.php");
require_once('../connectDB.php');
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

$auth = [
    'VAPID' => [
        'subject' => '/',
        'publicKey' => 'BC1VHFZkXPFeQxUZcPFaKmB0ybdEoJDP0NtRpRQcm9r1wDs59EP6HRxkBPmTqM5-I7YqPvuXh5WA2qVVozLsw4k',
        'privateKey' => 'StpkspHJM47XrXgAIcJbmUqlVtdWsVfLTdKo9BEEMq8',
    ],
];
$webPush = new WebPush($auth);

$push_result = [];
$user_id = "";
$pdo = connectDB();
$sql = 'SELECT * FROM p_license WHERE next_date <= :today ORDER BY user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':today', date('Y-m-d'), PDO::PARAM_STR);
$stmt->execute();
$p_license = $stmt->fetchAll();

for($i=0; $i<count($p_license); $i++){
    if($user_id != $p_license[$i]['user_id']){
        $sql = 'SELECT * FROM user WHERE user_id = :user_id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', $p_license[$i]['user_id'], PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();
        $subscription = json_decode($user['notif_info'], true);
        $user_id = $p_license[$i]['user_id'];
    }
    if(empty($subscription)){
        $user_id = "";
        continue;
    }
    
    $sql = 'SELECT * FROM license WHERE li_id = :li_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':li_id', $p_license[$i]['license_id'], PDO::PARAM_INT);
    $stmt->execute();
    $license = $stmt->fetch();

    $result = $webPush->sendOneNotification(Subscription::create($subscription), '{"title":"「'.$license['li_name'].'」の更新日が近付いています。", "body":"有効期限：'.$p_license[$i]['expiry_date'].'", "url":"../main/main.php"}', ['TTL' => 5000]);
    if(!$result){
        $push_result[] = "[".$user_id."-".$license['li_name'].']';
    }

    $cycle = "+1 years";
    if($p_license[$i]['notif_cycle']){
        $cycle = $p_license[$i]['notif_cycle'];
    }
    $now = new DateTime();
    $set_date = new DateTime();
    $expiry_date = new DateTime($p_license[$i]['expiry_date']);
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
                        }
                    }
                }
            }
        }
    }

    if($set_date != NULL){
        $set_date = $set_date->format('Y-m-d'); // 文字列に変換
    }
    
    $sql = 'UPDATE p_license SET next_date = :next_date WHERE user_id = :user_id AND license_id = :license_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':next_date', $set_date, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $p_license[$i]['user_id'], PDO::PARAM_STR);
    $stmt->bindValue(':license_id', $p_license[$i]['license_id'], PDO::PARAM_INT);
    $stmt->execute();
}

if(empty($push_result)){
    echo "true";
}
else{
    echo json_encode($push_result);
}
exit;
?>