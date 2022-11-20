<?php

use GuzzleHttp\Client;

/**
 * @param int $n
 * @return string
 */
function getRandomString(int $n = 8): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}

/**
 * @return string[]
 * @throws \GuzzleHttp\Exception\GuzzleException
 */
function createUser()
{
    $client = new Client([
        'headers' => ['Content-Type' => 'application/json']
    ]);

    $testUserData = ['username' => getRandomString(), 'password' => getRandomString()];
    $client->post('http://localhost:8080/api/v1/user/signup', ['body' => json_encode($testUserData)]);

    return $testUserData;
}

/**
 * @return mixed
 * @throws \GuzzleHttp\Exception\GuzzleException
 */
function createUserWithId()
{
    $client = new Client([
        'headers' => ['Content-Type' => 'application/json']
    ]);

    $testUserData = ['username' => getRandomString(), 'password' => getRandomString()];
    $response = $client->post('http://localhost:8080/api/v1/user/signup', ['body' => json_encode($testUserData)]);
    $data = json_decode($response->getBody()->getContents(), true);

    return $data['result']['id'];
}