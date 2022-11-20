<?php
namespace GameAPI\Tests\Integration;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class GameTest extends TestCase
{
    /**
     * @var Client $client
     */
    private Client $client;

    /**
     * @var array $testData
     */
    private array $testData;

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->client = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->testData = [
            'players' => [
                ['id' => createUserWithId(), 'score' => 10 ],
                ['id' => createUserWithId(), 'score' => 20 ]
            ]
        ];

        parent::__construct($name, $data, $dataName);
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testEndGame(){
        $response = $this->client->post('http://localhost:8080/api/v1/game/endgame', ['body' => json_encode($this->testData)]);
        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());

        $this->assertArrayHasKey('status', $data);
        $this->assertSame('success', $data['status']);
        $this->assertArrayHasKey('timestamp', $data);
        $this->assertArrayHasKey('result', $data);

        $this->assertIsArray($data['result']);

        foreach ($data['result'] as $result) {
            $this->assertArrayHasKey('id', $result);
            $this->assertNotNull($result['id']);
            $this->assertArrayHasKey('score', $result);
            $this->assertNotNull($result['score']);
        }
    }
}
