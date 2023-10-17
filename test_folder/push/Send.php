<?php
require_once '../vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;


const VAPID_SUBJECT = 'http://localhost';
const PUBLIC_KEY = 'BC1VHFZkXPFeQxUZcPFaKmB0ybdEoJDP0NtRpRQcm9r1wDs59EP6HRxkBPmTqM5-I7YqPvuXh5WA2qVVozLsw4k';
const PRIVATE_KEY = 'StpkspHJM47XrXgAIcJbmUqlVtdWsVfLTdKo9BEEMq8';

// push通知認証用のデータ
$subscription = Subscription::create([
    'endpoint' => 'https://fcm.googleapis.com/fcm/send/dszlSFNvTWM:APA91bH4tA2xjMud9N-IDJzw_T5xJfZ1BEQAXYQNDg51KcOJQWl_8li2CGtPeSO8AB9SGy1g7WIlAUhQ-vglRo-j5iy-JfJ_Q2AEfmtKMsUYlzvnDjFCbz7ALn_yCXbJ5AL3wxKlSdwI',
    'publicKey' => 'BGXMpFR9uLocejPAfdIwb8vEw2CD4WbRFX3q/BZKo1nRaL/MBmJ58z51cF312+sx09bMWV34YGYLL3A8a9MKbiA=',
    'authToken' => '8DuWEx5O8HoIj/MFDcReQA==',
]);


// ブラウザに認証させる
$auth = [
    'VAPID' => [
        'subject' => VAPID_SUBJECT,
        'publicKey' => PUBLIC_KEY,
        'privateKey' => PRIVATE_KEY,
    ]
];

$webPush = new WebPush($auth);

$report = $webPush->sendOneNotification(
    $subscription,
    'push通知の本文だよ！'
);

$endpoint = $report->getRequest()->getUri()->__toString();

if ($report->isSuccess()) {
    echo '送信成功！';
} else {
    echo '送信失敗やで';
}