<?php

namespace GameAPI\Services;

use GameAPI\Repositories\LeaderboardRepository;
use GameAPI\Repositories\UserRepository;

class LeaderboardService
{
    /**
     * @var LeaderboardRepository $leaderboardRepository
     */
    private LeaderboardRepository $leaderboardRepository;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param LeaderboardRepository $leaderboardRepository
     */
    public function __construct(LeaderboardRepository $leaderboardRepository, UserRepository $userRepository)
    {
        $this->leaderboardRepository = $leaderboardRepository;
        $this->userRepository = $userRepository;
    }

    public function getLeaderboard(): array
    {
        $scoreList = $this->leaderboardRepository->getScoreList();

        $rank = 1;
        $leaderboard = [];
        foreach ($scoreList as $id => $score) {
            $user = $this->userRepository->getUserIdAndUsernameById($id);

            $user['rank'] = $rank;
            $leaderboard[] = $user;
            $rank++;
        }

        return $leaderboard;
    }
}