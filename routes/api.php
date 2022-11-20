<?php
use FastRoute\RouteCollector;
use GameAPI\Controllers\UserController;
use GameAPI\Controllers\GameController;
use GameAPI\Controllers\LeaderboardController;

use function FastRoute\simpleDispatcher;

return simpleDispatcher(function (RouteCollector $collector) {
    $collector->addGroup('/api/v1', function (RouteCollector $group) {
        $group->addGroup('/user', function (RouteCollector $group) {
            $group->post('/signup', [UserController::class, 'signup']);
            $group->post('/signin', [UserController::class, 'signin']);
        });
        $group->post('/game/endgame', [GameController::class, 'endGame']);
        $group->get('/leaderboard', [LeaderboardController::class, 'leaderboard']);
    });
});