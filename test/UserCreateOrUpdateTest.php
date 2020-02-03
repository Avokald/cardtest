<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class UserCreateOrUpdateTest extends TestCase {
    public function testUserCreatedAndReturned(): void
    {
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

        $ch = curl_init();
        curl_setopt_array($ch, $options);


        $result = curl_exec($ch);

        $json_result = json_decode($result);

        $this->assertEquals($json_result->success, 1);
        $this->assertIsBool($json_result->card);
        $this->assertIsString($json_result->card_number);
        $this->assertIsString($json_result->card_track);
        $this->assertIsString($json_result->card_url);
        $this->assertEquals(parse_url($json_result->form_url, PHP_URL_PATH), $post['link']);
    }
}