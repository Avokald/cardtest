<?php
const REQUEST_NUMBER = 5;
$url = 'https://core.codepr.ru/api/v2/crm/user_create_or_update';
$post = [
    'app_key' => '5240f691-60b0-4360-ac1f-601117c5408f',
    'phone' => '+79111111111',
    'email' => 'ivan@ivan.ru',
    'name' => 'Иван',
    'surname' => 'Петров',
    'middlename' => 'Иванович',
    'birthday' => '11.12.1990',
    'discount' => '5',
    'bonus' => '0',
    'balance' => '0',
    'link' => 'testphp.codepr.ru'
];

$data_string = json_encode($post);

$options = [
    CURLOPT_TIMEOUT => 30,
    CURLOPT_POST => 1,
    CURLOPT_HEADER => 0,
    CURLOPT_URL => $url,
    CURLOPT_FRESH_CONNECT => 1,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_FORBID_REUSE => 1,
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_POSTFIELDS => $data_string,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Content-Length: '.strlen($data_string)
    ]
];

echo $data_string . '\n';
$ch = curl_init();
curl_setopt_array($ch, $options);

$time_start = microtime(true);

$result = curl_exec($ch);

$time_end = microtime(true);

$execution_time = ($time_end - $time_start) / 60;

echo "Initial request data: \n";
print_r($post);

echo "Initial request execution time: " . $execution_time . "\n";
echo "Response: \n";
print_r(json_decode($result));

echo "==============================================================================================================\n";
echo "Load test over " . REQUEST_NUMBER . " requests : \n";
echo shell_exec("ab -T 'application/json' -n " . REQUEST_NUMBER . " -p post.data https://core.codepr.ru/api/v2/crm/user_create_or_update");