<?php

namespace Vectorial1024\SymfonyGsaMailer;

use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;

/**
 * A Symfony mailer that uses Google Service Account (GSA) mailer for sending emails.
 * This uses the Google API Client package.
 */
class SymfonyGsaMailer extends AbstractTransport
{
    public function __toString(): string
    {
        // name of transport
        return "gsa";
    }

    protected function doSend(SentMessage $message): void
    {
        // todo actually send the mail
    }
}
