<?php
namespace GameAPI\Services;

use GameAPI\Repositories\GameRepository;
use GameAPI\Repositories\UserRepository;

class GameService
{
    /**
     * @var GameRepository $gameRepository
     */
    private GameRepository $gameRepository;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;


    /**
     * @param GameRepository $gameRepository
     * @param UserRepository $userRepository
     */
    public function __construct(GameRepository $gameRepository, UserRepository $userRepository)
    {
        $this->gameRepository = $gameRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function endGame(array $data): array
    {
        /*
           Burada iki tane ayni foreach olmasinin sebebi eger payload'da gelen players'larin herhangi biri yoksa bulunan
           players'larin da score degerlerinin kaydedilmesini istemedigim icin bu sekilde yaptim.
           Bunu pipeline ile cozmeyi denedim ama orada da data'yi kontrol etmek icin exec yapmam gerekiyor ve pipeline
           kapaniyor ve actigim pipeline'nin bir anlami kalmiyor. Tek cozumu sanirim 2 farkli redis instance olusturmak.
        */

        foreach ($data['players'] as $player) {
            if (!$this->userRepository->getUserById($player['id'])){
                throw new \Exception(sprintf('This user not found : user:id %s', $player['id']));
            }
        }

        foreach ($data['players'] as &$player) {
            $player['score'] = $this->gameRepository->setScoreById($player['id'], $player['score']);
        }

        return $data['players'];
    }

}