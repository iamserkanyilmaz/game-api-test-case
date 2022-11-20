<?php
namespace GameAPI\Tests\Integration;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class LeaderboardTest extends TestCase
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
    public function testLeaderboard(){
        $response = $this->client->get('http://localhost:8080/api/v1/leaderboard');
        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());

        $this->assertArrayHasKey('status', $data);
        $this->assertSame('success', $data['status']);
        $this->assertArrayHasKey('timestamp', $data);
        $this->assertArrayHasKey('result', $data);

        $rank = 1;
        foreach ($data['result'] as $result) {
            $this->assertArrayHasKey('id', $result);
            $this->assertNotNull($result['id']);
            $this->assertArrayHasKey('username', $result);
            $this->assertNotNull($result['username']);
            $this->assertArrayHasKey('username', $result);
            $this->assertNotNull($result['username']);
            $this->assertArrayHasKey('rank', $result);
            $this->assertNotNull($result['rank']);
            $this->assertSame($rank, $result['rank']);
            $rank++;
        }
    }
}