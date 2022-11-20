<?php
namespace GameAPI\Repositories;

use Redis;

class GameRepository
{
    const REDIS_SCORES_RANK_KEY = 'scores';

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

    public function setScoreById(int $id, int $score): float
    {
        return $this->redis->zIncrBy(self::REDIS_SCORES_RANK_KEY, $score, $id);
    }

}