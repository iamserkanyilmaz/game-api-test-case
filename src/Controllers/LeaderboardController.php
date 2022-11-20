<?php
namespace GameAPI\Controllers;

use GameAPI\Services\LeaderboardService;
use Symfony\Component\HttpFoundation\JsonResponse;

class LeaderboardController extends Controller
{
    /**
     * @var LeaderboardService
     */
    private LeaderboardService $leaderboardService;

    /**
     * @param LeaderboardService $leaderboardService
     */
    public function __construct(LeaderboardService $leaderboardService)
    {
        $this->leaderboardService = $leaderboardService;
    }

    /**
     * @return JsonResponse
     */
    public function leaderboard(): JsonResponse
    {
        try {
            return $this->successResponse($this->leaderboardService->getLeaderboard());
        } catch (\Exception $exception) {
            return $this->errorResponse([$exception->getMessage()]);
        }
    }
}