<?php
namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Workflow\Event\Event;

/**
 * Class WorkflowSubscriber
 * @package App\EventSubscriber
 */
class WorkflowSubscriber implements EventSubscriberInterface
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param Event $event
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function newToyRequest(Event $event)
    {
        $email = (new Email())
            ->from($event->getSubject()->getUser()->getEmail())
            ->to('dad@test.com')
            ->addTo('mum@test.com')
            ->subject('Demande de jouet - ' . $event->getSubject()->getName())
            ->text('Bonjour Maman et Papa, merci de me commander le jouet : ' . $event->getSubject()->getName());

        $this->mailer->send($email);
    }

    /**
     * @param Event $event
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function toyReceived(Event $event)
    {
        $email = (new Email())
            ->from('papa.noel@laponie.fr')
            ->to($event->getSubject()->getUser()->getEmail())
            ->subject('Ton jouet est la, oh oh oh !')
            ->text('Ton jouet est arrivé, amuse toi bien !');

        $this->mailer->send($email);
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            'workflow.toy_request.leave.request' => 'newToyRequest',
            'workflow.toy_request.entered.received' => 'toyReceived',
        ];
    }
}
