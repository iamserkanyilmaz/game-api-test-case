<?php
namespace GameAPI\Repositories;

use Redis;

class LeaderboardRepository
{
    /**
     * @var Redis
     */
    private Redis $redis;

    /**
     * @param Redis $redis
     */
    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    public function getScoreCount()
    {
        return $this->redis->zCard(GameRepository::REDIS_SCORES_RANK_KEY);
    }

    public function getScoreList()
    {
        return $this->redis->zRevRange(GameRepository::REDIS_SCORES_RANK_KEY, 0, $this->getScoreCount(), true);
    }
}