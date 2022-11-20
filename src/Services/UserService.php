<?php

namespace GameAPI\Services;


use GameAPI\Repositories\UserRepository;

class UserService
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $data
     * @return array
     */
    public function create(array $data) : array
    {
        if ($this->userRepository->getIdByUsername($data['username'])){
            throw new \Exception('This username has been registered before');
        }

        $data['id'] = $this->userRepository->getUserIncrementId();
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->userRepository->create($data['id'], $data);

        return $data;
    }

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function checkAndLogin(array $data): array
    {
        if (!$id = $this->userRepository->getIdByUsername($data['username'])){
            throw new \Exception('Registered user not found');
        }

        $user = $this->userRepository->getUserById($id);

        if(!password_verify($data['password'], $user['password'])){
            throw new \Exception('invalid password');
        }

        return [
            'username' => $user['username'],
            'id' => $id
        ];
    }
}