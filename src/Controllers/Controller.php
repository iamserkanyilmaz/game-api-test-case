<?php
namespace GameAPI\Controllers;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    /**
     * @param array $data
     * @param Constraint $constraint
     * @return array
     */
    public function validate(array $data, Constraint $constraint): array
    {
        $validator = Validation::createValidator();
        $messages = [];
        if ($errors = $validator->validate($data, $constraint)){
            /** @var ConstraintViolation $error */
            foreach ($errors as $error){
                $messages[] = $error->getMessage(). ' '.$error->getPropertyPath();
            }
        }

        return $messages;
    }

    /**
     * @param array $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public function successResponse(array $data, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        $response = new JsonResponse([
            'status' => 'success',
            'timestamp' => (new \DateTime())->format('Y-m-d H:i:s'),
            'result' => $data
        ], $statusCode);
        return $response->send();
    }

    /**
     * @param array $messages
     * @param int $statusCode
     * @return JsonResponse
     */
    public function errorResponse(array $messages, int $statusCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        $response = new JsonResponse([
            'status'=> 'error',
            'messages' => $messages
        ], $statusCode);

        return $response->send();
    }
}