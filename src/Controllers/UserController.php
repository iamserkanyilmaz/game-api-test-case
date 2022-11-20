<?php
namespace GameAPI\Controllers;

use GameAPI\Services\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints as Assert;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function signup(Request $request): JsonResponse
    {
        $constraint = new Assert\Collection([
            'username'=> new Assert\Required(),
            'password' => new Assert\Required()
        ]);

        $data = json_decode($request->getContent(), true);
        if ($messages = $this->validate($data, $constraint)){
            return $this->errorResponse($messages);
        }

        try {
            return $this->successResponse($this->userService->create($data));
        } catch (\Exception $exception) {
            return $this->errorResponse([$exception->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function signin(Request $request): JsonResponse
    {
        $constraint = new Assert\Collection([
            'username'=> new Assert\Required(),
            'password' => new Assert\Required()
        ]);

        $data = json_decode($request->getContent(), true);
        if ($messages = $this->validate($data, $constraint)){
            return $this->errorResponse($messages);
        }

        try {
            return $this->successResponse($this->userService->checkAndLogin($data));
        } catch (\Exception $exception) {
            return $this->errorResponse([$exception->getMessage()]);
        }
    }
}