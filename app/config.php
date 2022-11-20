<?php

return [
    'Redis' => function(){
        $redis =  new Redis();
        $redis->connect($_ENV['REDIS_HOST'], $_ENV['REDIS_PORT']);
        return $redis;
    },
    'userServices' => DI\create('UserService'),
    'userRepository' => DI\create('UserRepository'),
    'gameServices' => DI\create('GameService'),
    'gameRepository' => DI\create('GameRepository'),
    'leaderboardService' => DI\create('LeaderboardService'),
    'leaderboardRepository' => DI\create('LeaderboardRepository'),
];