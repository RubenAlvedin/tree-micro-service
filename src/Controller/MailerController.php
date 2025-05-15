<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\MailerService;
use App\Service\Utils\RequestChecker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class MailerController extends AbstractController
{
    public function __construct(
        private readonly MailerService $mailerService,
        private readonly RequestChecker $requestChecker,
    ) {}

    #[Route('/send-mail', name: 'send_mail', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        dd($data);

        $email = filter_var($data['to'] ?? '', FILTER_SANITIZE_EMAIL);
        $subject = $data['subject'] ?? '';
        $message = $data['message'] ?? '';

        if ($error = $this->requestChecker->checkEmail($email)) {
            return $error;
        }

        $this->mailerService->sendEmail($email, $subject, $message);

        return new JsonResponse(['message' => 'Mail sent!', 'status' => 200]);
    }
}
