<?php

namespace App\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Mailer\Bridge\Google\Smtp\GmailTransport;
use Symfony\Component\Mime\TemplatedEmail;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
class SendEmailCommand extends Command
{
    protected static $defaultName = 'send:email';
    private $mailer;
    public function __construct()
    {
        $this->mailer = $mailer;

        parent::__construct();
    }
    protected function configure()
    {
        $this
            ->setDescription('Command for send self email')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Command Send Self Email',
            '============'
        ]);
        // If you want use htmlTemplate and context function you need use TemplatedEmail
        // instead of Email object
        $email = (new TemplatedEmail())
            ->from('test42@gmail.com')
            ->to('test42@gmail.com')

            ->subject('I love Me')
            // If you want use text mail only
            ->text('Lorem ipsum...')
            // If you want use raw html
            ->html('<h1>Hello World</h1> <p>...</p>')
            // if you want use template from your twig file
            // template/emails/registration.html.twig
            ->htmlTemplate('emails/registration.html.twig')
            // with param
            ->context([
                'username' => 'John',
            ])
        ;
        $this->mailer->send($email);
        $output->writeln('Successful you send a self email');
    }
}