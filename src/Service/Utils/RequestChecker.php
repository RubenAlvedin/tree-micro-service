<?php declare(strict_types=1);

namespace App\Service\Utils;

use Symfony\Component\HttpFoundation\JsonResponse;

class RequestChecker
{
    public function checkEmail(string $email): ?JsonResponse
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new JsonResponse(['message' => 'Invalid email format.', 'status' => 400]);
        }
        return null;
    }
}
