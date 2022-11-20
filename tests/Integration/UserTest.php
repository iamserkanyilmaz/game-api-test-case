<?php
namespace GameAPI\Tests\Integration;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class UserTest extends TestCase
{
    /**
     * @var Client $client
     */
    public Client $client;

    /**
     * @param string|null $name
     * @param array $data
     * @param $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->client = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);

        parent::__construct($name, $data, $dataName);
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testUserSignup(){
        $userData = ['username' => getRandomString(), 'password' => getRandomString()];
        $response = $this->client->post('http://localhost:8080/api/v1/user/signup', ['body' => json_encode($userData)]);
        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());

        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('timestamp', $data);
        $this->assertArrayHasKey('result', $data);
        $this->assertArrayHasKey('username', $data['result']);
        $this->assertArrayHasKey('password', $data['result']);
        $this->assertArrayHasKey('id', $data['result']);


        $this->assertNotNull($data['result']['username']);
        $this->assertNotNull($data['result']['password']);
        $this->assertNotNull($data['result']['id']);
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testUserSignin(){
        $userData = createUser();
        $response = $this->client->get('http://localhost:8080/api/v1/user/signin', ['body' => json_encode($userData)]);
        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());

        $this->assertArrayHasKey('status', $data);
        $this->assertSame('success', $data['status']);
        $this->assertArrayHasKey('timestamp', $data);
        $this->assertArrayHasKey('result', $data);
        $this->assertArrayHasKey('username', $data['result']);
        $this->assertArrayHasKey('id', $data['result']);

        $this->assertNotNull($data['result']['username']);
        $this->assertNotNull($data['result']['id']);
    }
}