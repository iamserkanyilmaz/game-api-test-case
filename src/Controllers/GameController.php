<?php
namespace GameAPI\Controllers;

use GameAPI\Services\GameService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints as Assert;

class GameController extends Controller
{
    /**
     * @var GameService
     */
    private GameService $gameService;

    /**
     * @param GameService $gameService
     */
    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function endGame(Request $request): JsonResponse
    {
        $constraint = new Assert\Collection([
            'players' => new Assert\Required([
                new Assert\Type('array'),
                new Assert\All([
                    new Assert\Collection([
                        'id' => [
                            new Assert\NotBlank(),
                        ],
                        'score' => [
                            new Assert\NotBlank(),
                        ],
                    ])
                ]),
            ])
        ]);

        $data = json_decode($request->getContent(), true);

        if ($messages = $this->validate($data, $constraint)){
            return $this->errorResponse($messages);
        }

        try {
            return $this->successResponse($this->gameService->endGame($data));
        } catch (\Exception $exception) {
            return $this->errorResponse([$exception->getMessage()]);
        }
    }
}