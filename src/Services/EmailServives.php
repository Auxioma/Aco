<?php

namespace App\Services;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class EmailServives
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($form)
    {
        $email = (new TemplatedEmail())
            ->from($form->get('email')->getData())
            ->to('aco@acoproprete.com')
            ->replyTo($form->get('email')->getData())
            ->priority(5)
            ->subject('Nouveau message de ' . $form->get('nom')->getData())
            ->htmlTemplate('email/email.html.twig')
            ->context(compact('form'))
        ;
        $this->mailer->send($email);
    }
}