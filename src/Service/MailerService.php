<?php declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;

class MailerService
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly string $noReplyEmail,
        private readonly string $replyEmail,
        private readonly string $fromName,
    ) {}

    public function sendEmail(string $to, string $subject, string $content, ?string $fromName = null): void
    {
        $fromName = $fromName ?? $this->fromName;

        $email = (new Email())
            ->from(new Address($this->noReplyEmail, $fromName))
            ->replyTo($this->replyEmail)
            ->to($to)
            ->subject($subject)
            ->html("<p>$content</p>");

        $this->mailer->send($email);
    }
}
