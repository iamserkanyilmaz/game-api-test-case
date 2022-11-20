<?php
namespace GameAPI\Repositories;

use Redis;

class UserRepository
{

    const REDIS_USER_INCREMENT_ID_KEY = 'user_increment_id';
    const REDIS_LIST_USER_HASH_KEY = 'users:%s';
    const REDIS_USERS_KEY = 'user:%s';

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

    /**
     * @param int $id
     * @param array $data
     */
    public function create(int $id, array $data): void
    {
        $this->redis->hMSet(sprintf(self::REDIS_LIST_USER_HASH_KEY, $id), $data);
        $this->createUserKeyById($id, $data['username']);
    }

    /**
     * @param $id
     * @param $username
     * @return void
     */
    public function createUserKeyById($id, $username): void
    {
        $this->redis->set(sprintf(self::REDIS_USERS_KEY, $username), $id);
    }

    /**
     * @param $username
     * @return string
     */
    public function getIdByUsername($username): string
    {
        return $this->redis->get(sprintf(self::REDIS_USERS_KEY, $username));
    }

    /**
     * @param int $id
     * @return array
     */
    public function getUserById(int $id): array
    {
        return $this->redis->hGetAll(sprintf(self::REDIS_LIST_USER_HASH_KEY, $id));
    }

    /**
     * @return int
     */
    public function getUserIncrementId(): int
    {
        return $this->redis->incr(self::REDIS_USER_INCREMENT_ID_KEY);
    }

    /**
     * @param int $id
     * @return array
     */
    public function getUserIdAndUsernameById(int $id): array
    {
        return $this->redis->hMGet(sprintf(self::REDIS_LIST_USER_HASH_KEY, $id), ['id', 'username']);
    }
}