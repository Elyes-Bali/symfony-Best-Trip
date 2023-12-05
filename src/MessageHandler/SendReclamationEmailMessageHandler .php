<?php

namespace App\MessageHandler;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Message\SendReclamationEmailMessage;

class SendReclamationEmailMessageHandler implements MessageHandlerInterface
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function __invoke(SendReclamationEmailMessage $message)
    {
        $reclamation = $message->getReclamation();

        $email = (new \Symfony\Component\Mime\Email())
            ->from('abdennour.amdouni@esprit.tn')
            ->to($reclamation->getEmailu())
            ->subject('Reclamation Received')
            ->html('Your reclamation has been received successfully.');

        $this->mailer->send($email);
    }
}
