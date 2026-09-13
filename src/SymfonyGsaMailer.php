<?php

namespace Vectorial1024\SymfonyGsaMailer;

use Google\Client;
use Google\Service\Exception as GoogleException;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;
use InvalidArgumentException;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Message as SymfonyMessage;
use Symfony\Component\Mime\MessageConverter;

/**
 * A Symfony mailer that uses Google Service Account (GSA) mailer for sending emails.
 * This uses the Google API Client package.
 */
class SymfonyGsaMailer extends AbstractTransport
{
    protected Client $googleClient;
    protected Gmail $gmailService;

    public function __construct()
    {
        parent::__construct();

        $this->googleClient = new Client();
        $this->googleClient->addScope(Gmail::GMAIL_SEND);
        $this->googleClient->useApplicationDefaultCredentials();
        // todo read key from user config

        $this->gmailService = new Gmail($this->googleClient);
    }

    public function __toString(): string
    {
        // name of transport
        return "gsa";
    }

    /**
     * @param SentMessage $message
     * @return void
     * @throws GoogleException
     */
    protected function doSend(SentMessage $message): void
    {
        // todo various interfacing and customization
        $emailMsg = $message->getOriginalMessage();
        if (!($emailMsg instanceof SymfonyMessage)) {
            throw new InvalidArgumentException("Could not send mail: message is not of Symfony Message class");
        }
        $convertedBody = MessageConverter::toEmail($emailMsg);

        $mail = new Message();
        $mail->setRaw($convertedBody->getTextBody());
        $this->gmailService->users_messages->send("me", $mail);
    }
}
